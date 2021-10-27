<?php declare(strict_types=1);

namespace Cron\Tests\Infrastructure;

use Cron\Domain\Cron;
use Cron\Domain\CronRunnerServiceInterface;

final class CronRunnerFakeService implements CronRunnerServiceInterface
{
    private bool $executed;

    public function __construct()
    {
        $this->executed = false;
    }

    function execute(Cron $cron): void
    {
        $this->executed = true;
    }

    public function executed(): bool
    {
        return $this->executed;
    }
}