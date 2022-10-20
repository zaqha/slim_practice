<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;

return function (App $app) {

    $app->get('/', \App\Application\Actions\LoginPage::class);

    // 個人資料
    $app->group('/department', function (Group $group) {
        $group->get('/search', \App\Application\Actions\Department\DepartmentPage::class . ':search');
        $group->get('/insert', \App\Application\Actions\Department\DepartmentPage::class . ':insert');
        $group->get('/update/{id}', \App\Application\Actions\Department\DepartmentPage::class . ':update');

        $group->post('/search', \App\Application\Actions\Department\DepartmentAction::class . ':search');
        $group->post('/insert', \App\Application\Actions\Department\DepartmentAction::class . ':insert');
        $group->post('/update', \App\Application\Actions\Department\DepartmentAction::class . ':update');
        $group->post('/delete', \App\Application\Actions\Department\DepartmentAction::class . ':delete');
        $group->post('/import', \App\Application\Actions\Department\DepartmentAction::class . ':import');
        $group->post('/export', \App\Application\Actions\Department\DepartmentAction::class . ':export');
    });

    // 災情類別管理
    $app->group('/disaster_type', function (Group $group) {
        $group->get('', \App\Application\Actions\DisasterType\DisasterTypeAction::class);
        $group->post('/aboveInsert', \App\Application\Actions\DisasterType\DisasterTypeAction::class . ':aboveInsert');
        $group->post('/subInsert', \App\Application\Actions\DisasterType\DisasterTypeAction::class . ':subInsert');
        $group->post('/aboveUpdate', \App\Application\Actions\DisasterType\DisasterTypeAction::class . ':aboveUpdate');
        $group->post('/subUpdate', \App\Application\Actions\DisasterType\DisasterTypeAction::class . ':subUpdate');
        $group->post('/aboveDelete', \App\Application\Actions\DisasterType\DisasterTypeAction::class . ':aboveDelete');
        $group->post('/subDelete', \App\Application\Actions\DisasterType\DisasterTypeAction::class . ':subDelete');
        $group->post('/import', \App\Application\Actions\DisasterType\DisasterTypeAction::class . ':import');
        $group->post('/export', \App\Application\Actions\DisasterType\DisasterTypeAction::class . ':export');

        $group->get('/function/{roleId}', \App\Application\Actions\DisasterType\DisasterTypeAction::class. ':getsubName');
    });
    
};
