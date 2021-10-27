<?php declare(strict_types=1);

namespace Cron\Application\Run;

use Cron\Domain\CronRunnerServiceInterface;
use Cron\Domain\Validate\CronRunValidateInteraface;

final class RunCronCommandHandler
{
    private CronRunnerServiceInterface $runnerService;
    private CronRunValidateInteraface $cronRunValidator;

    public function __construct(CronRunnerServiceInterface $runnerService, CronRunValidateInteraface $cronRunValidator)
    {
        $this->runnerService = $runnerService;
        $this->cronRunValidator = $cronRunValidator;
    }

    public function handle(RunCronCommand $command)
    {
        if ($this->cronRunValidator->isValid($command->cron(), $command->currentTime())) {
            $this->runnerService->execute($command->cron());
        }
    }
}