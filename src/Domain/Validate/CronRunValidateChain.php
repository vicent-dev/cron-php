<?php declare(strict_types=1);

namespace Cron\Domain\Validate;

use Cron\Domain\Cron;
use DateTime;

final class CronRunValidateChain implements CronRunValidateInteraface
{
    private array $validators;

    public function __construct(CronRunValidateInteraface ...$validators)
    {
        $this->validators = $validators;
    }

    function isValid(Cron $cron, DateTime $time): bool
    {
        $valid = true;

        foreach ($this->validators as $validator) {
            if (!$validator->isValid($cron, $time)) {
                $valid = false;
                break;
            }
        }

        return $valid;
    }
}