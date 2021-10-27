<?php declare(strict_types=1);

namespace Cron\Infrastructure\ServiceProvider;

use Throwable;

final class ServiceNotFoundException extends \Exception
{
    public static function create(string $serviceName): self
    {
        return new self(sprintf('Can\'t found a service with name %s', $serviceName));
    }
}