<?php declare(strict_types=1);

namespace Cron\Infrastructure\ServiceProvider;

use Cron\Application\Edit\EditCronsCommand;
use Cron\Application\Edit\EditCronsCommandHandler;
use Cron\Application\Get\GetAllCronsQuery;
use Cron\Application\Get\GetAllCronsQueryHandler;
use Cron\Application\Run\RunCronCommand;
use Cron\Application\Run\RunCronCommandHandler;
use Cron\Domain\Validate\CronRunValidateChain;
use Cron\Domain\Validate\CronRunValidateDayOfMonth;
use Cron\Domain\Validate\CronRunValidateDayOfWeek;
use Cron\Domain\Validate\CronRunValidateHour;
use Cron\Domain\Validate\CronRunValidateMin;
use Cron\Domain\Validate\CronRunValidateMonth;
use Cron\Infrastructure\Console\EditConfigConsoleCommand;
use Cron\Infrastructure\Console\MainLoopConsoleCommand;
use Cron\Infrastructure\Repository\FileCronRepository;
use Cron\Infrastructure\Shell\CronRunnerService;
use Cron\Infrastructure\Shell\EditCronsService;
use League\Tactician\Setup\QuickStart;
use Pimple\Container;

final class CronServiceProvider
{
    private Container $container;

    protected function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get(string $service)
    {
        if (!isset($this->container[$service])) {
            throw ServiceNotFoundException::create($service);
        }

        return $this->container[$service];
    }

    public static function create(): self
    {
        $container = new Container();
        self::initServices($container);
        return new self($container);
    }

    private static function initServices(Container $container): void
    {
        self::initEnvVars($container);
        self::initInfraServices($container);
        self::initDomainServices($container);
        self::initUseCases($container);
        self::initBuses($container);
        self::initEntryPoints($container);
    }

    private static function initInfraServices(Container $container): void
    {
        $container['cron_file_repository'] = function ($c) {
            return new FileCronRepository($c['cron_file_path']);
        };
        $container['cron_runner_service'] = function () {
            return new CronRunnerService();
        };
        $container['crons_edit_service'] = function ($c) {
            return new EditCronsService($c['text_editor'], $c['cron_file_path']);
        };
    }

    private static function initDomainServices(Container $container): void
    {
        $container['cron_run_min_validator'] = function () {
            return new CronRunValidateMin();
        };
        $container['cron_run_hour_validator'] = function () {
            return new CronRunValidateHour();
        };
        $container['cron_run_day_of_month_validator'] = function () {
            return new CronRunValidateDayOfMonth();
        };
        $container['cron_run_month_validator'] = function () {
            return new CronRunValidateMonth();
        };
        $container['cron_run_day_of_week_validator'] = function () {
            return new CronRunValidateDayOfWeek();
        };
        $container['cron_run_chain_validator'] = function ($c) {
            return new CronRunValidateChain(
                $c['cron_run_min_validator'],
                $c['cron_run_hour_validator'],
                $c['cron_run_day_of_month_validator'],
                $c['cron_run_month_validator'],
                $c['cron_run_day_of_week_validator']
            );
        };
    }

    private static function initUseCases(Container $container): void
    {
        $container['cron_get_all_handler'] = function ($c) {
            return new GetAllCronsQueryHandler($c['cron_file_repository']);
        };
        $container['cron_run_handler'] = function ($c) {
            return new RunCronCommandHandler($c['cron_runner_service'], $c['cron_run_chain_validator']);
        };
        $container['crons_edit_handler'] = function ($c) {
            return new EditCronsCommandHandler($c['crons_edit_service']);
        };
    }

    private static function initBuses(Container $container): void
    {
        $container['query_bus'] = function ($c) {
            return QuickStart::create([
                GetAllCronsQuery::class => $c['cron_get_all_handler'],
            ]);
        };
        $container['command_bus'] = function ($c) {
            return QuickStart::create([
                RunCronCommand::class => $c['cron_run_handler'],
                EditCronsCommand::class => $c['crons_edit_handler'],
            ]);
        };
    }

    private static function initEntryPoints(Container $container): void
    {
        $container['cron_console_command'] = function ($c) {
            return new MainLoopConsoleCommand($c['query_bus'], $c['command_bus']);
        };
        $container['crons_edit_command'] = function ($c) {
            return new EditConfigConsoleCommand($c['command_bus']);
        };
    }

    private static function initEnvVars(Container $container): void
    {
        $container['cron_file_path'] = $_ENV['CONFIG_FILE_PATH'];
        $container['text_editor'] = $_ENV['EDITOR_CONFIG_FILE'];
    }
}