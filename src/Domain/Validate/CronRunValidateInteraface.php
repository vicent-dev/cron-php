<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

interface CronRunValidateInteraface
{
    function isValid(Cron $cron, DateTime $time, bool $previous = true): bool;
}