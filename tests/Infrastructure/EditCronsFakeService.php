<?php declare(strict_types=1);

namespace Cron\Tests\Infrastructure;

use Cron\Domain\EditCronsServiceInterface;

final class EditCronsFakeService implements EditCronsServiceInterface
{
    private bool $executed;

    public function __construct()
    {
        $this->executed = false;
    }

    function execute(): void
    {
        $this->executed = true;
    }

    public function executed(): bool
    {
        return $this->executed;
    }
}