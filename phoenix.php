<?php

use Slim\App;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use App\Application\Settings\SettingsInterface;

require __DIR__ . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/app/settings.php';
$settings($containerBuilder);

// Build DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();

$settings = $container->get(SettingsInterface::class);

return $settings->get('phoenix');
