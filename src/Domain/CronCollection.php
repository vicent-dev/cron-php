<?php declare(strict_types=1);

namespace Cron\Domain;

final class CronCollection implements \Iterator
{
    private int $position;
    private array $crons;

    public static function create(Cron...$crons): self
    {
        $cronCollection = new self();
        $cronCollection->crons = $crons;
        $cronCollection->position = 0;
        return $cronCollection;
    }

    public function current(): Cron
    {
        return $this->crons[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->crons[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function add(Cron $cron): void
    {
        $this->crons[] = $cron;
    }
}