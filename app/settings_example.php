<?php
declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// Timezone
date_default_timezone_set('Asia/Taipei');

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object 新分支
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            $SYS_TITLE = 'EOC專案';
            $DB_HOST = 'localhost';
            $DB_USR = 'root';
            $DB_ENC_PWD = '';
            $DB_NAME = 'EOC';
            return new Settings([
                // 'install_dir' => 'slim-sk', 
                'install_dir' => basename(dirname(__DIR__)), // this install_dir will work when installed in a 1st-level folder under docroot
                'sys_title' => $SYS_TITLE,
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => $SYS_TITLE,
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/log.' . date('Ymd') . '.txt',
                    'level' => Logger::DEBUG,
                ],
                'view' => [
                    'path' => '../templates',
                    'options' => ['cache' => false, 'debug' => true],
                ],
                'dbConnectionInfo' => [
                    // these are defined in public/.htaccess
                    'host' => $DB_HOST,
                    'user' => $DB_USR,
                    'pswd' => $DB_ENC_PWD,
                    'name' => $DB_NAME,
                ],
                'phoenix' => [
                    'migration_dirs' => [
                        'first' => __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'migrations',
                    ],
                    'environments' => [
                        'local' => [
                            'adapter' => 'mysql',
                            'host' => $DB_HOST,
                            'port' => 3306,
                            'username' => $DB_USR,
                            'password' => $DB_ENC_PWD,
                            'db_name' => $DB_NAME,
                            'charset' => 'utf8'
                        ],
                    ],
                    'default_environment' => 'local',
                    'log_table_name' => 'phoenix_log',
                ],
            ]);
        }
    ]);
};
