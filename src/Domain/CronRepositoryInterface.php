<?php declare(strict_types=1);

namespace Cron\Domain;

interface CronRepositoryInterface
{
    function findAll(): CronCollection;
}