<?php declare(strict_types=1);

namespace Cron\Tests\Application\Get;

use Cron\Application\Get\GetAllCronsQuery;
use Cron\Application\Get\GetAllCronsQueryHandler;
use Cron\Domain\CronRepositoryInterface;
use Cron\Tests\Infrastructure\InMemoryCronRepository;
use PHPUnit\Framework\TestCase;

final class GetAllCronsQueryHandlerTest extends TestCase
{
    private CronRepositoryInterface $repository;
    protected function setUp(): void
    {
        $this->repository = new InMemoryCronRepository();
        parent::setUp();
    }

    /** * @test */
    public function getAllCrons()
    {
        $handler = new GetAllCronsQueryHandler($this->repository);
        $crons = $handler->handle(new GetAllCronsQuery());
        self::assertCount(1, $crons);
    }
}