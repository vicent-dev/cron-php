<?php declare(strict_types=1);

namespace Cron\Application\Run;

use Cron\Domain\Cron;
use DateTime;

final class RunCronCommand
{
    private Cron $cron;
    private DateTime $currentTime;

    public function __construct(Cron $cron, DateTime $currentTime)
    {
        $this->cron = $cron;
        $this->currentTime = $currentTime;
    }

    public function cron(): Cron
    {
        return $this->cron;
    }

    public function currentTime(): DateTime
    {
        return $this->currentTime;
    }
}