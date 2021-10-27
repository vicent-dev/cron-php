<?php declare(strict_types=1);

namespace Cron\Infrastructure\Repository;

use Cron\Domain\Cron;
use Cron\Domain\CronCollection;
use Cron\Domain\CronRepositoryInterface;

final class FileCronRepository implements CronRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    function findAll(): CronCollection
    {
        $cronCollection = new CronCollection();

        $fh = fopen($this->filePath, 'rb');

        while ($line = fgets($fh)) {
            $parsed = explode(' ', $line);
            for($i = 0; $i < 5; $i++) {
                $parsed[$i] = $parsed[$i] === '*' ? null : (int)$parsed[$i];
            }
            $cronCollection->add(Cron::create(...$parsed));
        }

        fclose($fh);

        return $cronCollection;
    }
}