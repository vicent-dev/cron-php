<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

final class CronRunValidateMonth implements CronRunValidateInteraface
{
    function isValid(Cron $cron, DateTime $time): bool
    {
        if (null === $cron->month()) {
            return true;
        }

        return $cron->month() === (int)$time->format('m');
    }
}