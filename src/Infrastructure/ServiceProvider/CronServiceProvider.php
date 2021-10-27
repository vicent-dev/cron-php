<?php declare(strict_types=1);

namespace Cron\Infrastructure\ServiceProvider;

use Cron\Application\Get\GetAllCronsCommand;
use Cron\Application\Get\GetAllCronsCommandHandler;
use Cron\Application\Run\RunCronCommand;
use Cron\Application\Run\RunCronCommandHandler;
use Cron\Infrastructure\Console\MainLoopCommand;
use Cron\Infrastructure\Repository\FileCronRepository;
use League\Tactician\Setup\QuickStart;
use Pimple\Container;

final class CronServiceProvider
{
    private Container $container;

    protected function __construct(Container $container)
    {
        $this->container = $container;
    }

    public static function create(): self
    {
        $container = new Container();
        self::initServices($container);
        return new self($container);
    }


    public function get(string $service)
    {
        if(!isset($this->container[$service])) {
            throw ServiceNotFoundException::create($service);
        }

        return $this->container[$service];
    }

    private static function initServices(Container $container): void
    {
        $container['cron_file_path'] = $_ENV['CONFIG_FILE_PATH'];

        //repository
        $container['cron_file_repository'] = function ($c) {
            return new FileCronRepository($c['cron_file_path']);
        };

        //use cases
        $container['cron_get_all_handler'] = function ($c) {
            return new GetAllCronsCommandHandler($c['cron_file_repository']);
        };
        $container['cron_run_handler'] = function ($c) {
            return new RunCronCommandHandler();
        };

        //command / query bus
        $container['query_bus'] = function ($c) {
            return QuickStart::create([
                GetAllCronsCommand::class => $c['cron_get_all_handler'],
            ]);
        };
        $container['command_bus'] = function ($c) {
            return QuickStart::create([
                RunCronCommand::class => $c['cron_run_handler'],
            ]);
        };

        //console commands
        $container['cron_console_command'] = function ($c) {
            return new MainLoopCommand($c['query_bus'], $c['command_bus']);
        };
    }
}