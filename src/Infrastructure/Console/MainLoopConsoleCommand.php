<?php declare(strict_types=1);

namespace Cron\Infrastructure\Console;

use Cron\Application\Get\GetAllCronsCommand;
use Cron\Application\Run\RunCronCommand;
use DateTime;
use League\Tactician\CommandBus;

final class MainLoopConsoleCommand
{
    private CommandBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(CommandBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function __invoke()
    {
        $crons = $this->queryBus->handle(new GetAllCronsCommand());

        while(true) {
            $now = new DateTime();

            foreach ($crons as $cron) {
                $this->commandBus->handle(new RunCronCommand($cron, $now));
            }

            sleep(1);
        }
    }
}