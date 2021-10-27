<?php declare(strict_types=1);

namespace Cron\Application\Get;

use Cron\Domain\CronCollection;
use Cron\Domain\CronRepositoryInterface;

final class GetAllCronsQueryHandler
{
    private CronRepositoryInterface $repository;

    public function __construct(CronRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(GetAllCronsQuery $command): CronCollection
    {
        return $this->repository->findAll();
    }
}