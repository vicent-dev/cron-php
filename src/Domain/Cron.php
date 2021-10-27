<?php declare(strict_types=1);

namespace Cron\Domain;

final class Cron
{
    private ?int $min, $hour, $dayOfMonth, $month, $dayOfWeek;
    private string $user, $command;

    public function __construct(?int $min, ?int $hour, ?int $dayOfMonth, ?int $month, ?int $dayOfWeek, string $user, string $command)
    {
        $this->min = $min;
        $this->hour = $hour;
        $this->dayOfMonth = $dayOfMonth;
        $this->month = $month;
        $this->dayOfWeek = $dayOfWeek;
        $this->user = $user;
        $this->command = $command;
    }


    public static function create($min, $hour, $dayOfMonth, $month, $dayOfWeek, $user, $command): self
    {
        return new self($min, $hour, $dayOfMonth, $month, $dayOfWeek, $user, $command);
    }
}