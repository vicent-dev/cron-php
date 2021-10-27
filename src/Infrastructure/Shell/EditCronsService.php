<?php declare(strict_types=1);

namespace Cron\Infrastructure\Shell;

use Cron\Domain\EditCronsServiceInterface;

final class EditCronsService implements EditCronsServiceInterface
{
    private string $editor;
    private string $filePath;

    public function __construct(string $editor, string $filePath)
    {
        $this->editor = $editor;
        $this->filePath = $filePath;
    }

    function execute(): void
    {
        shell_exec(sprintf('%s %s', $this->editor, $this->filePath));
    }
}