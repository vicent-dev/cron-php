<?php declare(strict_types=1);

namespace Cron\Tests\Application\Run;

use Cron\Application\Run\RunCronCommand;
use Cron\Application\Run\RunCronCommandHandler;
use Cron\Domain\CronRunnerServiceInterface;
use Cron\Tests\Infrastructure\CronRunnerFakeService;
use PHPUnit\Framework\TestCase;

final class RunCronCommandHandlerTest extends TestCase
{
    private CronRunnerServiceInterface $runnerService;
    protected function setUp(): void
    {
        $this->runnerService = new CronRunnerFakeService();
        parent::setUp();
    }

    /** * @test */
    public function cronRunned()
    {
        $handler = new RunCronCommandHandler($this->runnerService);
        $handler->handle(new RunCronCommand());

        self::assertTrue($this->runnerService->executed());
    }

    /** * @test */
    public function cronNotRunned()
    {
        $handler = new RunCronCommandHandler($this->runnerService);
        $handler->handle(new RunCronCommand());

        self::assertFalse($this->runnerService->executed());
    }
}