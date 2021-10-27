<?php declare(strict_types=1);

namespace Cron\Domain;

interface CronRunnerServiceInterface
{
    function execute(Cron $cron): void;
}