<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

final class CronRunValidateDayOfWeek implements CronRunValidateInteraface
{
    function isValid(Cron $cron, DateTime $time, bool $previous = true): bool
    {
        if (null === $cron->dayOfWeek()) {
            return $previous;
        }

        return $cron->dayOfWeek() === (int)$time->format('w');
    }
}