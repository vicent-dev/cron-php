<?php declare(strict_types=1);

namespace Cron\Domain;

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

    public function command(): string
    {
        return $this->command;
    }

    public function min(): ?int
    {
        return $this->min;
    }

    public function hour(): ?int
    {
        return $this->hour;
    }

    public function dayOfMonth(): ?int
    {
        return $this->dayOfMonth;
    }

    public function month(): ?int
    {
        return $this->month;
    }

    public function dayOfWeek(): ?int
    {
        return $this->dayOfWeek;
    }
}