<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

final class CronRunValidateMin implements CronRunValidateInteraface
{
    function isValid(Cron $cron, DateTime $time): bool
    {
        if (null === $cron->min()) {
            return true;
        }

        return $cron->min() === (int)$time->format('i');
    }
}