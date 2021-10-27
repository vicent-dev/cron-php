<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

final class CronRunValidateDayOfMonth implements CronRunValidateInteraface
{
    function isValid(Cron $cron, DateTime $time, bool $previous = true): bool
    {
        if (null === $cron->dayOfMonth()) {
            return $previous;
        }

        return $cron->dayOfMonth() === (int)$time->format('d');
    }
}