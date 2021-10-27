<?php declare(strict_types=1);

namespace Cron\Infrastructure\Shell;

use Cron\Domain\Cron;
use Cron\Domain\CronRunnerServiceInterface;

final class CronRunnerService implements CronRunnerServiceInterface
{
    function execute(Cron $cron): void
    {
        shell_exec($cron->command());
    }
}