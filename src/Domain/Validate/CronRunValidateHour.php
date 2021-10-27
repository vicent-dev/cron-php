<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

final class CronRunValidateHour implements CronRunValidateInteraface
{
    function isValid(Cron $cron, DateTime $time): bool
    {
        return true;
    }
}