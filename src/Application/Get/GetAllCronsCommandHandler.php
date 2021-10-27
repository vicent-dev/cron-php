<?php declare(strict_types=1);

namespace Cron\Application\Get;

use Cron\Domain\CronCollection;
use Cron\Domain\CronRepositoryInterface;

final class GetAllCronsCommandHandler
{
    private CronRepositoryInterface $repository;

    public function __construct(CronRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(GetAllCronsCommand $command): CronCollection
    {
        return $this->repository->findAll();
    }
}