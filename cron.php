<?php declare(strict_types=1);

use Cron\Infrastructure\ServiceProvider\CronServiceProvider;

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$serviceProvider = CronServiceProvider::create();

if(count($argv) === 1) {
    $serviceProvider->get('cron_console_command')();
    return;
}

if(isset($argv[1]) && $argv[1] === '-e') {
    $serviceProvider->get('crons_edit_command')();
    return;
}

