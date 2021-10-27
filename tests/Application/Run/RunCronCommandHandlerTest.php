<?php declare(strict_types=1);

namespace Cron\Tests\Application\Run;

use Cron\Application\Run\RunCronCommand;
use Cron\Application\Run\RunCronCommandHandler;
use Cron\Domain\CronRunnerServiceInterface;
use Cron\Domain\Validate\CronRunValidateChain;
use Cron\Domain\Validate\CronRunValidateDayOfMonth;
use Cron\Domain\Validate\CronRunValidateDayOfWeek;
use Cron\Domain\Validate\CronRunValidateHour;
use Cron\Domain\Validate\CronRunValidateInteraface;
use Cron\Domain\Validate\CronRunValidateMin;
use Cron\Domain\Validate\CronRunValidateMonth;
use Cron\Tests\Infrastructure\CronRunnerFakeService;
use PHPUnit\Framework\TestCase;

final class RunCronCommandHandlerTest extends TestCase
{
    private CronRunnerServiceInterface $runnerService;
    private CronRunValidateInteraface $validatorService;

    protected function setUp(): void
    {
        $this->runnerService = new CronRunnerFakeService();

        $this->validatorService = new CronRunValidateChain(
            new CronRunValidateMin(),
            new CronRunValidateHour(),
            new CronRunValidateDayOfMonth(),
            new CronRunValidateMonth(),
            new CronRunValidateDayOfWeek()
        );

        parent::setUp();
    }

    /** * @test */
    public function cronRunned()
    {
        $handler = new RunCronCommandHandler($this->runnerService, $this->validatorService);
        $handler->handle(new RunCronCommand());

        self::assertTrue($this->runnerService->executed());
    }

    /** * @test */
    public function cronNotRunned()
    {
        $handler = new RunCronCommandHandler($this->runnerService, $this->validatorService);
        $handler->handle(new RunCronCommand());

        self::assertFalse($this->runnerService->executed());
    }
}