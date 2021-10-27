<?php declare(strict_types=1);

namespace Cron\Tests\Infrastructure;

use Cron\Domain\Cron;
use Cron\Domain\CronCollection;
use Cron\Domain\CronRepositoryInterface;

final class InMemoryCronRepository implements CronRepositoryInterface
{
    private CronCollection $fakeCrons;

    public function __construct()
    {
        $this->fakeCrons = CronCollection::create(
            Cron::create(null, null, null, null, null, "ls"),
        );

    }

    function findAll(): CronCollection
    {
        return $this->fakeCrons;
    }
}