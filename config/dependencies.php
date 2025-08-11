<?php

declare(strict_types=1);


use Dotenv\Dotenv;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$app_env = getenv('APP_ENV') ?: 'prod';
$file = ($app_env === 'dev') ? "dev.env" : ".env";
if (file_exists(__DIR__ . '/env/' . $file)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/env/', $file);
    $dotenv->load();
} else {
    exit(".Env file not found");
}

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/common/*.php'),
    new PhpFileProvider(__DIR__ . '/' . (getenv('APP_ENV') ?: 'prod') . '/*.php'),
]);

return $aggregator->getMergedConfig();
