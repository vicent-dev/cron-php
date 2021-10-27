<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

final class CronRunValidateHour implements CronRunValidateInteraface
{
    function isValid(Cron $cron, DateTime $time, bool $previous = true): bool
    {
        if (null === $cron->hour()) {
            return $previous;
        }

        return $cron->hour() === (int)$time->format('h');
    }
}