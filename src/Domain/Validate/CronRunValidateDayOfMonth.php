<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

final class CronRunValidateDayOfMonth implements CronRunValidateInteraface
{
    function isValid(Cron $cron, DateTime $time): bool
    {
        if (null === $cron->dayOfMonth()) {
            return true;
        }

        return $cron->dayOfMonth() === (int)$time->format('d');
    }
}