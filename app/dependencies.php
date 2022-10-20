<?php
declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        App::class => function (ContainerInterface $c) {
            AppFactory::setContainer($c);
            $app = AppFactory::create();

            return $app;
        },

        PDO::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class)->get('dbConnectionInfo');

            $dbHost = $settings['host'];
            $dbUser = $settings['user'];
            $dbPassword = $settings['pswd'];
            $dbName = $settings['name'];
            return new PDO(
                'mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8',
                $dbUser,
                $dbPassword,
                array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                      PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '+08:00'",
                      PDO::ATTR_EMULATE_PREPARES=> true)
            );
        },

        TwigMiddleware::class => function (ContainerInterface $c) {
            return TwigMiddleware::createFromContainer($c->get(App::class), Twig::class);
        },

        Twig::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $twigSettings = $settings->get('view');
            $sys_title = $settings->get('sys_title');
            $install_dir = $settings->get('install_dir');

            $twig = Twig::create(
                $twigSettings['path'], 
                $twigSettings['options']
            );
            $twig->addExtension(new \Twig\Extension\DebugExtension());
            $twig->addExtension(new \App\Application\CustomTwigExtension($sys_title, $install_dir));
            return $twig;
        },
    ]);
};
