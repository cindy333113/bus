<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response, $args) {

        $session = $request->getAttribute('session');
        
        $view = render('index', [
            'msg' => 'hello',
        ]);

        $response->getBody()->write($view);
        
        return $response;
    });

    $app->get('/login', function (Request $request, Response $response, $args) {
        
        $view = render('login');
        $response->getBody()->write($view);

        return $response;
    });

    $app->post('/login', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody(); //$_POST

        $account = $data['account'] ?? '';
        $password = $data['password'] ?? '';

        $result = verifyPassengerLogin($account, $password);
        if ($result) {
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
    $app->get('/driver', function (Request $request, Response $response, $args) {

        echo '<pre>';
        var_dump(DB::fetchAll('driver'));

        return $response;
    });

    $app->get('/driver/{id}', function (Request $request, Response $response, $args) {

        $driverId = $args['id'];

        //司機駕駛的公車
        $bus = DB::find('bus', $driverId, 'driver_id');
        $departTime = $bus['DEPART_TIME'];

        var_dump(countTimeToArriveNextStop($departTime));

        return $response;
    });

    /* =========================================================================
    * = STOP
    * =========================================================================
    **/
    $app->get('/stop', function (Request $request, Response $response, $args) {

        render('stop', ['msg' => '增加站牌資訊',]);

        return $response;
    });

    $app->post('/stop/add', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $result = DB::create('stop', $data);

        render('stop', ['msg' => $result ? '增加站牌資訊成功':'增加站牌資訊失敗',]);

        return $response;
    });

    $app->post('/stop/update', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $stopId = $data['STOP_ID'];

        $result = DB::update('stop', "`STOP_ID` = {$stopId}", $data);

        render('stop', ['msg' => $result ? '修改站牌資訊成功':'修改站牌資訊失敗',]);

        return $response;
    });
};
