<?php declare(strict_types=1);

namespace Cron\Tests\Application\Edit;

use Cron\Application\Edit\EditCronsCommand;
use Cron\Application\Edit\EditCronsCommandHandler;
use Cron\Domain\EditCronsServiceInterface;
use Cron\Tests\Infrastructure\EditCronsFakeService;
use PHPUnit\Framework\TestCase;

final class EditCronsCommandHandlerTest extends TestCase
{
    private EditCronsServiceInterface $editCronsService;

    protected function setUp(): void
    {
        $this->editCronsService = new EditCronsFakeService();
        parent::setUp();
    }

    /** * @test */
    public function fakeEditCrons()
    {
        $handler = new EditCronsCommandHandler($this->editCronsService);
        $handler->handle(new EditCronsCommand());
        self::assertTrue($this->editCronsService->executed());
    }

}