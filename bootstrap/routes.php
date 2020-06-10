<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    /*$app->get('/', function (Request $request, Response $response, $args) {
        $routes = DB::fetchAll('route');
        $route = DB::find('route','842','route_name');
        render('index', [
            'msg' => 'HAHA',
            'rows' => $routes,
            'row' => $route,
        ]);
        return $response;
    });*/
/*
    $app->get('/sql', function (Request $request, Response $response, $args) {
        $conn = DB::getconnection();
        $stmt = $conn->prepare("SELECT route_name from `route` ");
        $stmt->execute();

        $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($a, JSON_UNESCAPED_UNICODE);
        return $response;
    });
*/
    /* =========================================================================
    * = GETON
    * =========================================================================
    **/
    $app->get('/geton', function (Request $request, Response $response, $args) {
        render('geton', [
            'msg' => '輸入要預約上車的資料',
            
        ]);
        return $response;
    });
    $app->post('/geton/add', function (Request $request, Response $response, $args) {
        //找出預約的車子
        $data = $request->getParsedBody();
        $passengerId = 3;
        $stopname = $data['stop_name'];
        $stopOfCollect = DB::find('stop', $stopname, 'stop_name');
        $stop_id = $stopOfCollect['stop_id'];
        var_dump($stopname,$stop_id);

        $routename = $data['route_name'];
        $routeOfColllect = DB::find('route', $routename, 'route_name');
        $route_id = $routeOfColllect['route_id'];
        var_dump($routename,$route_id);

        
        $directionId = $data['direction'];
        $result =$conn = DB::getconnection();
        $stmt = $conn->prepare("INSERT INTO `geton`(`passenger_id`, `bus_id`, `stop_id`) VALUES ($passengerId,(SELECT bus_id from bus where route_id=$route_id and direction=$directionId),$stop_id)");
        $stmt->execute();
        $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($a, JSON_UNESCAPED_UNICODE);
        render('geton', ['msg' => $result ? '預約成功' : '預約失敗',]);

        return $response;
        return $response;
    });
    $app->post('/geton/delete', function (Request $request, Response $response, $args) {
        //刪除預約上車
        $data = $request->getParsedBody();
        $geton_id = $data['geton_id'];
        $result = DB::delete('geton', $geton_id, 'geton_id');
        render('collect', ['msg' => $result ? '取消預約成功' : '取消預約失敗',]);
        return $response;
    });
/*
    $app->get('/temap', function (Request $request, Response $response, $args) { //顯示站名
        //列出所有站牌
        $routes = DB::fetchAll('route');
        $row = array_map(function ($route) {
            return $route['route_name'];
        }, $routes);
        //echo $routes;
        var_dump($row);
        return $response;
    });

    $app->get('/', function (Request $request, Response $response, $args) { //顯示站名
        $routes = DB::fetchAll('route');
        render('index', [
            'msg' => 'HAHA',
            'rows' => $routes,
        ]);
        return $response;
    });
*/
    /* =========================================================================
    * = COLLECT
    * =========================================================================
    **/

    $app->get('/collect', function (Request $request, Response $response, $args) {
        //列出id=?的顧客所收藏的站牌及路線
        //$passengerId = $args['id'];
        $passengerId = 2;
        $conn = DB::getconnection();
        $stmt = $conn->prepare("SELECT stop_name,r.route_name from collect c,stop s,route r where passenger_id=$passengerId and c.stop_id=s.stop_id and c.route_id=r.route_id ");
        $stmt->execute();
        $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($a);
        //echo json_encode($a, JSON_UNESCAPED_UNICODE);
        render('collect', [
            'msg' => '輸入要新增修改的資料',
            'stopList' => $a,
        ]);
        return $response;
    });
    /*$app->get('/collect', function (Request $request, Response $response, $args) {
        $passengerId = 2;
        $collectlist=DB::find('collect',$passengerId,'passenger_id');
        render('collect', [
            'msg' => '輸入要新增修改的資料',
            'collectlist' => $collectlist,        
        ]);
        return $response;
    });*/
    $app->post('/collect/add', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody(); //$_POST
        var_dump($data);
        $stopname = $data['stop_name'];
        $stopOfCollect = DB::find('stop', $stopname, 'stop_name');
        $stop_id = $stopOfCollect['stop_id'];

        $routename = $data['route_name'];
        $routeOfColllect = DB::find('route', $routename, 'route_name');
        $route_id = $routeOfColllect['route_id'];

        $data2 = [
            "passenger_id" => 2,
            "stop_id" => $stop_id,
            "route_id" => $route_id
        ];
        $result = DB::create('collect', $data2);
        render('collect', ['msg' => $result ? '增加收藏站牌資訊成功' : '增加收藏站牌資訊失敗',]);

        return $response;
    });
    $app->post('/collect/delete', function (Request $request, Response $response, $args) {
        //刪除收藏站牌
        $data = $request->getParsedBody();
        $collectId = $data['passenger_id'];
        $result = DB::delete('collect', $collectId, 'collect_id');
        render('collect', ['msg' => $result ? '刪除收藏站牌資訊成功' : '刪除收藏站牌資訊失敗',]);
        return $response;
    });
    /*
    $app->post('/collect/update', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $passengerId = $data['passenger_id'];

        $result = DB::update('collect', "`passenger_id` = {$passengerId}", $data);

        render('collect', ['msg' => $result ? '修改站牌資訊成功':'修改站牌資訊失敗',]);

        return $response;
    });
    */
    /*
    $app->get('/test2', function (Request $request, Response $response, $args) {
        //新增
        var_dump(DB::creat('collect',$data);
        return $response;
    });
*/

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
    });
    */
    /* =========================================================================
    * = STOP
    * =========================================================================
    **/

    $app->get('/stop', function (Request $request, Response $response, $args) {

        render('stop', ['msg' => '增加站牌資訊',]);

        return $response;
    });

    //預約上車
    $app->post('/stop/book/geton', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody(); //$_POST

        //$data['STOP_TIME'] = date('Y-m-d H:i:s');
        $data['stop_longitude'] = 0;
        $data['stop_latitude'] = 0;

        $result = DB::create('geton', $data);
        /*
            [
                'stop_id' => '1',
                'stop_name' => 'name'
            ]
        */

        render('geton', ['msg' => $result]);

        return $response;
    });
    //預約下車
    $app->post('/stop/book/getoff', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $result = DB::fetchAll('getoff');

        render('getoff', ['msg' => $result]);

        return $response;
    });
    /*
    $app->post('/stop/update', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $stopId = $data['stop_id'];

        $result = DB::update('stop', "`stop_id` = {$stopId}", $data);

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
*/
};
