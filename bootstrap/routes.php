<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response, $args) {

        render('index', [
            'msg' => 'hello',
        ]);

        return $response;
    });

    $app->post('/login', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $account = $data['account'] ?? '';
        $password = $data['password'] ?? '';

        $result = verifyPassengerLogin($account, $password);
        if($result)
        {
            render('index', ['msg' => 'success',]);
        } else {
            render('index', ['msg' => 'wrong',]);
        }

        return $response;
    });

    /* =========================================================================
    * = DRIVER
    * =========================================================================
    **/
    $app->get('/driver/{id}', function (Request $request, Response $response, $args) {

        $driverId = $args['id'];

        //司機駕駛的公車
        $bus = DB::find('bus', $driverId, 'driver_id');
        $departTime = $bus['DEPART_TIME'];

        var_dump(countTimeToArriveNextStop($departTime));

        return $response;
    });

    /* =========================================================================
    * = USERS
    * =========================================================================
    **/
    $app->get('/users', function (Request $request, Response $response, $args) {

        $result = DB::fetchAll('users');

        $response->getBody()->write(json_encode($result));

        return $response;
    });

    $app->get('/users/{id}', function (Request $request, Response $response, $args) {

        $id = $args['id'];
        $result = DB::find('users', $id);

        $response->getBody()->write(json_encode($result));
        return $response;
    });
};
