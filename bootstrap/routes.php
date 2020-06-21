<?php

declare(strict_types=1);

use Middleware\AuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response, $args) {

        $view = render('index', [
            'title' => '首頁',
        ]);

        $response->getBody()->write($view);

        return $response;
    });

    /* =========================================================================
    * = 註冊登入
    * =========================================================================
    **/

    $app->get('/login', function (Request $request, Response $response, $args) {
        $view = render('login');

        $response->getBody()->write($view);

        return $response;
    });

    $app->post('/login', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody(); //$_POST

        $identity = $data['identity'] ?? '';
        $account = $data['account'] ?? '';
        $password = $data['password'] ?? '';

        if ($id = Auth::login($account, $password, $identity)) {
            $_SESSION['auth'] = ['id' => $id, 'identity' => $identity];
            return $response->withHeader('Location', "/{$identity}");
        } else {
            $view = render('login', ['msg'=>'帳號或密碼錯誤']);
            $response->getBody()->write($view);
        }

        return $response;
    });

    $app->get('/logout', function (Request $request, Response $response, $args) {

        unset($_SESSION['auth']);

        return $response->withHeader('Location', '/');
    });

    /* =========================================================================
    * = blacklist
    * =========================================================================
    **/
    $app->get('/blacklist', function (Request $request, Response $response, $args) { //顯示站名
        $conn = DB::getconnection();
        $stmt = $conn->prepare("SELECT * from `black_list` ");
        $stmt->execute();

        $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($a, JSON_UNESCAPED_UNICODE);

        render('/blacklist', [
            'a' => $a,
        ]);
        return $response;
    });

    //抓黑名單
    $app->get('/blacklist/{id}', function (Request $request, Response $response, $args) {
        $black_List = DB::fetchAll('black_list');
        $passengerId = $args['id'];

        $blackListbypassengerId = array_filter($black_List, function ($black) use ($passengerId) {
            return $black['passenger_id'] == $passengerId;
        });
        $blacktime = count($blackListbypassengerId);
        $isBlack = (count($blackListbypassengerId) >= 3) ? TRUE : FALSE;
        var_dump($blacktime);
        if ($isBlack = (count($blackListbypassengerId) >= 3)) {
            $thispassenger = '是黑名單';
        } else {
            $thispassenger = '不是黑名單';
        }
        var_dump($thispassenger);
        render('/blacklist', [
            'isBlack' => $isBlack,
            'thispassenger' => $thispassenger,
            'blacktime' => $blacktime,
        ]);
        return $response;
    });

    //記黑名單
    $app->post('/blacklist/add', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $result = DB::create('black_list', $data);

        render('blacklist', ['msg' => $result ? '黑名單新增一次' : '新增黑名單失敗',]);

        return $response;
    });

    /* =========================================================================
    * = Passenger
    * =========================================================================
    **/

    $app->group('/passenger', function (Group $group) {

        $group->get('', function (Request $request, Response $response, $args) {

            $user = $request->getAttribute('user');

            $view = render('passenger', ['user' => $user]);
            $response->getBody()->write($view);

            return $response;
        });

        /* =========================================================================
        * = Bus
        * =========================================================================
        **/

        $group->get('/bus/{id}', function (Request $request, Response $response, $args) {

            $driverId = $args['id'];

            //司機駕駛的公車
            $bus = DB::find('bus', $driverId, 'driver_id');
            $departTime = $bus['DEPART_TIME'];

            $body = $response->getBody();
            $body->write(countTimeToArriveNextStop($departTime));

            return $response;
        });

        /* =========================================================================
        * = GetOn
        * =========================================================================
        **/

        $group->get('/geton', function (Request $request, Response $response, $args) {
            $user = $request->getAttribute('user');
            $passengerId = $user['passenger_id'];

            /*
            $conn = DB::getconnection();
            $stmt = $conn->prepare("SELECT direction,unusal,g.bus_id,g.geton_id,stop_name,r.route_name from geton g,stop s,route r,bus b where g.passenger_id=$passengerId and g.stop_id=s.stop_id and g.bus_id=b.bus_id and b.route_id=r.route_id");
            $stmt->execute();
            $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
            */

            $getOnList = DB::fetchAll('geton');
            $getOnListByPassenger = [];

            foreach ($getOnList as $key => $getOn){

                $stop = DB::find('stop',$getOn['stop_id']);
                $bus = DB::find('bus',$getOn['bus_id']);
                $route = DB::find('route',$bus['route_id']);

                array_push($getOnListByPassenger,[
                    'getonRecord' => $getOn,
                    'route_name' => $route['route_name'],
                    'stop_name' => $stop['stop_name']
                ]);
            
            };
            
            $view = render('geton', [
                'user' => $user,
                'msg' => '輸入要新增修改的資料',
                'List' => $getOnListByPassenger,
            ]);

            $response->getBody()->write($view);

            return $response;
        });

        $group->post('/geton/add', function (Request $request, Response $response, $args) {
            //找出預約的車子
            $data = $request->getParsedBody();
            $passengerId = 2;
            $stopname = $data['stop_name'];
            $stopOfCollect = DB::find('stop', $stopname, 'stop_name');
            $stop_id = $stopOfCollect['stop_id'];
            //var_dump($stopname,$stop_id);

            $routename = $data['route_name'];
            $routeOfColllect = DB::find('route', $routename, 'route_name');
            $route_id = $routeOfColllect['route_id'];
            //var_dump($routename,$route_id);

            $directionId = $data['direction'];
            $unusal = $data['unusal'];
            $result = $conn = DB::getconnection();
            $sql = "INSERT INTO `geton`(`passenger_id`, `bus_id`, `stop_id`, `unusal`) VALUES 
            ($passengerId,(SELECT bus_id from bus where route_id=$route_id and direction=$directionId),$stop_id,$unusal)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //echo json_encode($a, JSON_UNESCAPED_UNICODE);
            render('geton', ['msg' => $result ? '預約成功' : '預約失敗',]);
            return $response;
        });

        $group->post('/geton/delete', function (Request $request, Response $response, $args) {
            //刪除預約上車
            $data = $request->getParsedBody();
            $geton_id = $data['geton_id'];
            $result = DB::delete('geton', $geton_id, 'geton_id');
            render('geton', ['msg' => $result ? '取消預約成功' : '取消預約失敗',]);
            return $response;
        });

        /* =========================================================================
        * = getoff
        * =========================================================================
        **/

        $group->get('/getoff', function (Request $request, Response $response, $args) {
            $passengerId = 2;
            $getoffResult = DB::find('getoff', $passengerId, 'passenger_id');
            var_dump($getoffResult);
            render('/getoff', [
                'msg' => '輸入要預約上車的資料',
                'getoffResult' => $getoffResult,
            ]);
            return $response;
        });

        $group->post('/getoff/add', function (Request $request, Response $response, $args) {
            //找出預約的車子
            $data = $request->getParsedBody();
            $passengerId = 2;
            $stopname = $data['stop_name'];
            $stopOfCollect = DB::find('stop', $stopname, 'stop_name');
            $stop_id = $stopOfCollect['stop_id'];
            var_dump($stopname, $stop_id);

            $routename = $data['route_name'];
            $routeOfColllect = DB::find('route', $routename, 'route_name');
            $route_id = $routeOfColllect['route_id'];
            var_dump($routename, $route_id);


            $directionId = $data['direction'];
            $unusal = $data['unusal'] ?? "";
            $result = $conn = DB::getconnection();
            $stmt = $conn->prepare("INSERT INTO `getoff`(`passenger_id`, `bus_id`, `stop_id`, `unusal`) VALUES 
    ($passengerId,(SELECT bus_id from bus where route_id=$route_id and direction=$directionId),$stop_id,$unusal)");
            $stmt->execute();
            $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($a, JSON_UNESCAPED_UNICODE);
            render('getoff', ['msg' => $result ? '預約成功' : '預約失敗',]);
            return $response;
        });

        $group->post('/getoff/delete', function (Request $request, Response $response, $args) {
            //刪除預約上車
            $data = $request->getParsedBody();
            $getoff_id = $data['getoff_id'];
            $result = DB::delete('getoff', $getoff_id, 'getoff_id');
            render('getoff', ['msg' => $result ? '取消預約成功' : '取消預約失敗',]);
            return $response;
        });

        /* =========================================================================
        * = myfavourite
        * =========================================================================
        **/

        $group->get('/myfavourite', function (Request $request, Response $response, $args) {
            //列出id=?的顧客所收藏的站牌及路線
            //$passengerId = $args['id'];
            //$passengerId=$request->getAttribute('user');
            $passengerId = 2;
            $conn = DB::getconnection();
            $stmt = $conn->prepare("SELECT stop_name,r.route_name,collect_id from collect c,stop s,route r where passenger_id=$passengerId and c.stop_id=s.stop_id and c.route_id=r.route_id ");
            $stmt->execute();
            $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($a);
            //echo json_encode($a, JSON_UNESCAPED_UNICODE);
            render('myfavourite', [
                'msg' => '輸入要新增修改的資料',
                'stopList' => $a,
            ]);
            return $response;
        }); //->add(new AuthMiddleware);  

        $group->post('/myfavourite/add', function (Request $request, Response $response, $args) {

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
            header("Location:/myfavourite");
            render('/myfavourite', ['msg' => $result ? '增加收藏站牌資訊成功' : '增加收藏站牌資訊失敗',]);

            return $response;
        });

        $group->post('/myfavourite/delete', function (Request $request, Response $response, $args) {
            //刪除收藏站牌
            $data = $request->getParsedBody(); //$_POST
            $collectId = $data['id'];

            DB::delete('collect', $collectId, 'collect_id');
            header("Location:/myfavourite");
            render('myfavourite', [
                'msg' => '刪除成功',
            ]);
        });
    })->add(new AuthMiddleware('passenger'));

    /* =========================================================================
    * = User Group
    * =========================================================================
    **/

    /*
    $app->get('/passenger', function (Request $request, Response $response, $args) {

        $user = $request->getAttribute('user');

        $view = render('/user', ['user' => $user]);
        $response->getBody()->write($view);

        return $response;
    })->add(new AuthMiddleware('passenger'));

    $app->get('/driverlogin', function (Request $request, Response $response, $args) { //顯示站名
        render('driverlogin', []);
        return $response;
    });
    */

    /* =========================================================================
    * = DRIVER Group
    * =========================================================================
    **/
    /*
    $app->group('/driver', function (Group $group) {

        $group->get('', function (Request $request, Response $response, $args) {

            $user = $request->getAttribute('user');

            $view = render('user', ['user' => $user]);
            $response->getBody()->write($view);

            return $response;
        });

        $group->get('/{id}', function (Request $request, Response $response, $args) {

            $driverId = $args['id'];

            //司機駕駛的公車
            $bus = DB::find('bus', $driverId, 'driver_id');
            $departTime = $bus['DEPART_TIME'];

            $body = $response->getBody();
            $body->write(countTimeToArriveNextStop($departTime));

            return $response;
        });
    })->add(new AuthMiddleware('driver'));
    */
    /* =========================================================================
    * = STOP
    * =========================================================================
    **/

    //列出預約上車
    $app->post('/stop/update', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $stopId = $data['stop_id'];

        $result = DB::update('stop', "`stop_id` = {$stopId}", $data);

        return $response;
    });

    $app->post('/planroute', function (Request $request, Response $response, $args) { //顯示站名
        $data = $request->getParsedBody();
        $start=$data['start'];
        $goal=$data['goal'];
        $conn = DB::getconnection();
        $stmt = $conn->prepare("select rt.route_id,route_name from route_stop rt,route r where rt.stop_id in ($start,$goal) and rt.route_id=r.route_id group by rt.route_id having count(rt.route_id)=2 ");
        $stmt->execute();

        $planroute = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($planroute, JSON_UNESCAPED_UNICODE);
        
        render('/planroute', []);
        return $response;
    });

    //計算公車站牌
    $app->get('/bus/{id}', function (Request $request, Response $response, $args) {

        $busId = $args['id'];

        $bus = DB::find('bus', $busId);
        $departureTime = $bus['time'];
        $countOfStop = countStopBusPassed($departureTime);

        $routeId = $bus['route_id'];

        $amountStopOfRoute = countStopOfRoute($routeId);

        $isGoing = floor($countOfStop / $amountStopOfRoute) / 2 == 0 ? '1' : '0';

        $StopOfCurrentDrive = $countOfStop % $amountStopOfRoute;
        $currentOrder =  $isGoing ? $StopOfCurrentDrive : $amountStopOfRoute - $StopOfCurrentDrive;
        $stopList = DB::fetchAll('stop');

        render('bus', [
            'bus' => $bus,
            'departureTime' => $departureTime,
            'currentOrder' => $currentOrder,
            'currentStopName' => findStopNameByRouteOrder($routeId, $currentOrder)
        ]);

        return $response;
    });

    $app->get('/destination', function (Request $request, Response $response, $args) { //顯示站名
        render('destination', []);
        return $response;
    });
    /* =========================================================================
    * = search
    * =========================================================================
    **/
    //用站牌尋找公車
    $app->get('/destination/routesearch/{stop_id}', function (Request $request, Response $response, $args) {
        $stopId =$args['stop_id'];
        $stop = DB::find('route_stop', $stopId);
        $stopId = $stop['stop_id'];
        $routeListByStop = findRouteByStop($stopId);
        $stopdata=DB::find('stop',$stopId);
        $stopname=$stopdata['stop_name'];
        //var_dump($stopname);
        render('stoproute', [
            'routeListByStop' => $routeListByStop,
            'stop_name'=>$stopname,
            'msg'=>$routeListByStop['route_id']
        ]);

        return $response;
    });
    /*
        //example
        foreach($routeListByStop as $key => $route){
            echo $route['route_name'].'<br>';
        }
        */
    //搜尋公車列出站牌
    $app->get('/destination/searchstop', function (Request $request, Response $response, $args) {

        $view = render('destination');
        $response->getBody()->write($view);
        return $response;
    });
    //搜尋公車列出站牌
    $app->post('/destination/searchstop', function (Request $request, Response $response, $args) {
        $data = $request->getParsedBody();

        $routename = $data['route_name'];
        $route = DB::find('route', $routename, 'route_name');
        $routeId = $route['route_id'];
        $stop = DB::find('route_stop', $routeId);
        $routeStopId = $stop['route_id'];
        $stopNameByRoute = findStopListByRoute($routeStopId);
        $view = render('destination', [
            'stopNameByRoute' => $stopNameByRoute,
        ]);

        $response->getBody()->write($view);

        return $response;
    });

    $app->post('/planroute/add', function (Request $request, Response $response, $args) { //顯示站名
        $data = $request->getParsedBody();
        $start = $data['start'];
        $goal = $data['goal'];

        $startdata = DB::find('stop', $start, 'stop_name');
        $goaldata = DB::find('stop', $goal, 'stop_name');
        $startid = $startdata['stop_id'];
        $goalid = $goaldata['stop_id'];
        //var_dump($startid,$goalid);
        $conn = DB::getconnection();
        $stmt = $conn->prepare("select rt.route_id,route_name from route_stop rt,route r where rt.stop_id in ($startid,$goalid) and rt.route_id=r.route_id group by rt.route_id having count(rt.route_id)=2 ");
        $stmt->execute();

        $planroute = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //echo json_encode($planroute, JSON_UNESCAPED_UNICODE);
        $view = render('planroute', [
            'msg' => $planroute,
        ]);
        $response->getBody()->write($view);
        return $response;
    });

    $app->get('/addblack', function (Request $request, Response $response, $args) {
    
        $view = render('/addblack');
        $response->getBody()->write($view);
        return $response;
    });
};