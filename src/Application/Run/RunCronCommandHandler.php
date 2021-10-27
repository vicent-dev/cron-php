<?php declare(strict_types=1);

namespace Cron\Application\Run;

use Cron\Domain\CronRunnerServiceInterface;

final class RunCronCommandHandler
{
    private CronRunnerServiceInterface $runnerService;

    public function __construct(CronRunnerServiceInterface $runnerService)
    {
        $this->runnerService = $runnerService;
    }

    public function handle(RunCronCommand $command)
    {
        if($command->cron()->mustRun($command->currentTime())) {
            $this->runnerService->execute($command->cron());
        }
    }
}