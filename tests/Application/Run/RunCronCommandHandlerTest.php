<?php declare(strict_types=1);

namespace Cron\Tests\Application\Run;

use Cron\Application\Run\RunCronCommand;
use Cron\Application\Run\RunCronCommandHandler;
use Cron\Domain\Cron;
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
        $handler->handle(new RunCronCommand(Cron::create(null, null, null, null, null, 'ls'),
        new \DateTime('2021-01-01 00:00:00')));

        self::assertTrue($this->runnerService->executed());
    }

    /** * @test */
    public function cronRunnedNotEmpty()
    {
        $handler = new RunCronCommandHandler($this->runnerService, $this->validatorService);
        $handler->handle(new RunCronCommand(Cron::create(1, 1, 1, 1, null, 'ls'),
            new \DateTime('2021-01-01 01:01:00')));

        self::assertTrue($this->runnerService->executed());
    }

    /** * @test */
    public function cronNotRunnedMin()
    {
        $handler = new RunCronCommandHandler($this->runnerService, $this->validatorService);
        $handler->handle(new RunCronCommand(Cron::create(1, null, null, null, null, 'ls'),
            new \DateTime('2021-01-01 00:00:00')));

        self::assertFalse($this->runnerService->executed());
    }

    /** * @test */
    public function cronNotRunnedHour()
    {
        $handler = new RunCronCommandHandler($this->runnerService, $this->validatorService);
        $handler->handle(new RunCronCommand(Cron::create(null, 1, null, null, null, 'ls'),
            new \DateTime('2021-01-01 00:00:00')));

        self::assertFalse($this->runnerService->executed());
    }

    /** * @test */
    public function cronNotRunnedDayOfMonth()
    {
        $handler = new RunCronCommandHandler($this->runnerService, $this->validatorService);
        $handler->handle(new RunCronCommand(Cron::create(null, null, 2, null, null, 'ls'),
            new \DateTime('2021-01-01 00:00:00')));

        self::assertFalse($this->runnerService->executed());
    }

    /** * @test */
    public function cronNotRunnedMonth()
    {
        $handler = new RunCronCommandHandler($this->runnerService, $this->validatorService);
        $handler->handle(new RunCronCommand(Cron::create(null, null, null, 3, null, 'ls'),
            new \DateTime('2021-01-01 00:00:00')));

        self::assertFalse($this->runnerService->executed());
    }

    /** * @test */
    public function cronNotRunnedDayOfWeek()
    {
        $handler = new RunCronCommandHandler($this->runnerService, $this->validatorService);
        $handler->handle(new RunCronCommand(Cron::create(null, null, null, null, 2, 'ls'),
            new \DateTime('2021-01-01 00:00:00')));

        self::assertFalse($this->runnerService->executed());
    }
}