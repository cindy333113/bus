<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
//登入
return function (App $app) {

    $app->get('/', function (Request $request, Response $response, $args) {

        render('index1', [
            'msg' => 'hello',
        ]);

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
    /*
    $app->get('/driver', function (Request $request, Response $response, $args) {

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
    });*/

    /* =========================================================================
    * = STOP
    * =========================================================================
    **/
    $app->get('/stop', function (Request $request, Response $response, $args) {

        render('stop', ['msg' => '增加站牌資訊',]);

        return $response;
    });
//預約上車
    $app->post('/stop/add', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $result = DB::create('geton', $data);

        render('geton', ['msg' => $result ? '增加站牌成功' : '增加站牌失敗',]);

        return $response;
    });
//預約下車
    $app->post('/stop/add', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $result = DB::create('getoff', $data);

        render('getoff', ['msg' => $result ? '增加站牌成功' : '增加站牌失敗',]);

        return $response;
    });
/*
    $app->post('/stop/update', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $stopId = $data['stop_id'];

        $result = DB::update('stop', "`stop_id` = {$stopId}", $data);

        render('stop', ['msg' => $result ? '修改站牌資訊成功' : '修改站牌資訊失敗',]);

        return $response;
    });*/
//路線
    $app->get('/', function (Request $request, Response $response, $args) {
        $routes = DB::fetchAll('route');

        $row = array_map(function($route){
            return $route['route_name'];
        }, $routes);

        render('index', ['msg' => '搜尋站牌']);

        return $response;
    });
    $app->get('/route-stop/{id}', function (Request $request, Response $response, $args) {
        $routeStopList = DB::fetchAll('route_stop');
        $routesId=$args['id'];
        $routeStopListbyrouteId = array_filter($routeStopList,function($routeStop)use($routesId){
            return $routeStop['route_id'] == $routesId;
        });
        $stopList = array_map(function($routeStop){
            return DB::find('stop', $routeStop['stop_id']);
        },$routeStopListbyrouteId);

        render('index', ['stopList' => $stopList]);

        return $response;
    });
    $app->get('/search', function (Request $request, Response $response, $args) {
    $conn=DB::getconnection();
    $stmt =$conn->prepare("SELECT route_name from `route` Where`route_name` Like :search");
    $stmt->execute();
    $a=$stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($a, JSON_UNESCAPED_UNICODE);
    return $response;
    });
    //註冊（待測試）
    /*$app->get('/insert', function (Request $request, Response $response, $args) {
        $conn=DB::getconnection();
        $data=[];
    $stmt =$conn->prepare("INSERT INTO users (passenger_account, passenger_password, passenger_name) VALUES (:passenger_account, :passenger_password, :passenger_name) ");
        $stmt->execute([
            'account' => $data['passenger_account'],
            'password' => $data['passenger_password'],
            'name' => $data['passenger_name']
        ]);

        $a=$stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($a, JSON_UNESCAPED_UNICODE);
        return $response;
    });*/
    //註冊
    $app->post('/register/add', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $result = DB::create('passenger', $data);

        render('passenger', ['msg' => $result ? '註冊成功' : '註冊失敗',]);

        return $response;
    });
    //抓黑名單
    $app->get('/black_list/{id}', function (Request $request, Response $response, $args) {
        $black_List = DB::fetchAll('black_list');
        $passengerId=$args['id'];

        $blackListbypassengerId = array_filter($black_List,function($black)use($passengerId){
            return $black['passenger_id'] == $passengerId;
        }); 
        
        $isBlack = (count($blackListbypassengerId) >= 3) ? TRUE:FALSE;

        render('index', ['isBlack' => $isBlack]);

        return $response;
    });
    //記黑名單
    $app->post('/', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $result = DB::create('black_list', $data);

        render('black_list', ['msg' => $result ? '黑名單新增一次' : '新增黑名單失敗',]);

        return $response;
    });

};
