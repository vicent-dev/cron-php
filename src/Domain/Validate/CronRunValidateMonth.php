<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

final class CronRunValidateMonth implements CronRunValidateInteraface
{
    function isValid(Cron $cron, DateTime $time, bool $previous = true): bool
    {
        if (null === $cron->month()) {
            return $previous;
        }

        return $cron->month() === (int)$time->format('m');
    }
}