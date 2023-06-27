<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Actions\Sensor\ListSensorsAction;
use App\Application\Actions\Sensor\ViewSensorAction;
use App\Application\Actions\Sensor\StoreSensorAction;
use App\Application\Actions\Sensor\EditSensorAction;
use App\Application\Actions\Sensor\DeleteSensorAction;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/sensor', function (Group $group) {
        $group->get('', ListSensorsAction::class);
        $group->get('/{id}', ViewSensorAction::class);
        $group->post('', StoreSensorAction::class);
        $group->put('/{id}', EditSensorAction::class);
        $group->delete('/{id}', DeleteSensorAction::class);
    });
};
