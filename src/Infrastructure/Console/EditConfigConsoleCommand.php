<?php declare(strict_types=1);

namespace Cron\Infrastructure\Console;

use Cron\Application\Edit\EditCronsCommand;
use League\Tactician\CommandBus;

final class EditConfigConsoleCommand
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke()
    {
        $this->commandBus->handle(new EditCronsCommand());
    }
}