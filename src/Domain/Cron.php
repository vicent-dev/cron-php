<?php declare(strict_types=1);

namespace Cron\Domain;

use DateTime;

final class Cron
{
    private ?int $min, $hour, $dayOfMonth, $month, $dayOfWeek;
    private string $command;

    public function __construct(?int $min, ?int $hour, ?int $dayOfMonth, ?int $month, ?int $dayOfWeek, string $command)
    {
        $this->min = $min;
        $this->hour = $hour;
        $this->dayOfMonth = $dayOfMonth;
        $this->month = $month;
        $this->dayOfWeek = $dayOfWeek;
        $this->command = $command;
    }


    public static function create($min, $hour, $dayOfMonth, $month, $dayOfWeek, $command): self
    {
        return new self($min, $hour, $dayOfMonth, $month, $dayOfWeek, $command);
    }

    public function mustRun(DateTime $dateTime): bool
    {
        $run = true;

        return $run;
    }

    public function command(): string
    {
        return $this->command;
    }

    public function user(): string
    {
        return $this->user;
    }
}