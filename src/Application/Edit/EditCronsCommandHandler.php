<?php declare(strict_types=1);

namespace Cron\Application\Edit;

use Cron\Domain\EditCronsServiceInterface;

final class EditCronsCommandHandler
{
    private EditCronsServiceInterface $editCronsService;

    public function __construct(EditCronsServiceInterface $editCronsService)
    {
        $this->editCronsService = $editCronsService;
    }

    public function handle(EditCronsCommand $command)
    {
        $this->editCronsService->execute();
    }
}