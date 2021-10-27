<?php declare(strict_types=1);

namespace Cron\Domain;

interface EditCronsServiceInterface
{
    function execute(): void;
}