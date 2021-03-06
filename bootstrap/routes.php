<?php

declare(strict_types=1);

use Middleware\AuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/index', function (Request $request, Response $response, $args) {
        $user = $request->getAttribute('user');
        render('index', [
            'msg' => '首頁',
            'userdata'=>$user,

        ]);
        return $response;
    })->add(new AuthMiddleware('passenger'));;
    $app->get('/english', function (Request $request, Response $response, $args) {
        $user = $request->getAttribute('user');
        render('english', [
            'msg' => '輸入要預約上車的資料',

        ]);
        return $response;
    });
    $app->get('/ublack', function (Request $request, Response $response, $args) {
        
        render('ublack', [
            'msg' => '黑名單小壞壞',
            'userdata'=>$user,

        ]);
        return $response;
    });
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
    * = blacklist
    * =========================================================================
    **/
    $app->get('/blacklist', function (Request $request, Response $response, $args) { //顯示站名
        $user = $request->getAttribute('user');
        $isdriver=$user['driver_id'];
        $conn = DB::getconnection();
        $stmt = $conn->prepare("SELECT b.*,p.passenger_name from black_list b,passenger p where p.passenger_id=b.passenger_id ");
        $stmt->execute();

        $showblack = $stmt->fetchAll(PDO::FETCH_ASSOC);

        render('/blacklist', [
            'a' => $showblack,
            'isdriver'=>$isdriver,
        ]);
        return $response;
    })->add(new AuthMiddleware('driver'));;

    
    //記黑名單
    $app->post('/blacklist/add', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $result = DB::create('black_list', $data);

        render('blacklist', ['msg' => $result ? '黑名單新增一次' : '新增黑名單失敗',]);

        return $response;
    });
    /* =========================================================================
    * = GETON
    * =========================================================================
    **/
    $app->get('/geton', function (Request $request, Response $response, $args) {
        $black_List = DB::fetchAll('black_list');
        $user = $request->getAttribute('user');
        $passengerId=$user['passenger_id'];

        $blackListbypassengerId = array_filter($black_List, function ($black) use ($passengerId) {
            return $black['passenger_id'] == $passengerId;
        });
        $blacktime = count($blackListbypassengerId);
        $isBlack = (count($blackListbypassengerId) >= 3) ? TRUE : FALSE;
        if ($isBlack = (count($blackListbypassengerId) >= 3)) {
            //thispassenger = '是黑名單';
            render('/ublack', [
            ]);
        } else {
            //thispassenger = '不是黑名單';

        //$passengerId = 2;
        $conn = DB::getconnection();
        $stmt = $conn->prepare("SELECT direction,unusal,g.geton_id,stop_name,r.route_name,g.bus_id 
        from geton g,stop s,route r,bus b where g.passenger_id=$passengerId and g.stop_id=s.stop_id and g.bus_id=b.bus_id and b.route_id=r.route_id");
        $stmt->execute();
        $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
        render('/geton', [
            'msg' => '輸入要新增修改的預約下車的資料',
            'List' => $a,
            'userdata'=>$user,
        ]);
        return $response;
    }})->add(new AuthMiddleware('passenger'));
    /*
    $app->get('/geton', function (Request $request, Response $response, $args) {
        $passengerId = 2;
        $getonResult = DB::find('geton',$passengerId,'passenger_id');
        var_dump($getonResult);
        render('/geton', [
            'msg' => '輸入要預約上車的資料',
            'getonResult'=>$getonResult,
        ]);
        return $response;
    });*/


    $app->post('/geton/add', function (Request $request, Response $response, $args) {
        //找出預約的車子
        $user = $request->getAttribute('user');
        $passengerId=$user['passenger_id'];
        $data = $request->getParsedBody();
        $user = $request->getAttribute('user');
        $passengerId=$user['passenger_id'];
        //$passengerId = 2;
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
        $stmt = $conn->prepare("INSERT INTO `geton`(`passenger_id`, `bus_id`, `stop_id`, `unusal`) VALUES 
        ($passengerId,(SELECT bus_id from bus where route_id=$route_id and direction=$directionId),$stop_id,$unusal)");
        $stmt->execute();
        $getonadd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //echo json_encode($a, JSON_UNESCAPED_UNICODE);
        render('geton', ['msg' => $result ? '預約成功' : 
        '預約失敗','userdata'=>$user,]);
        return $response;
    })->add(new AuthMiddleware('passenger'));;
    $app->post('/geton/delete', function (Request $request, Response $response, $args) {
        //刪除預約上車
        $user = $request->getAttribute('user');
        $data = $request->getParsedBody();
        //var_dump($data);
        $geton_id = $data['geton_id'];
        DB::delete('geton', $geton_id, 'geton_id');
        header("Location:/geton");
        render('geton', ['msg' =>'取消預約成功',
        'userdata'=>$user,]);
        
    })->add(new AuthMiddleware('passenger'));;
 

      /* =========================================================================
    * = getoff
    * =========================================================================
    **/
    $app->get('/getoff', function (Request $request, Response $response, $args) {
        $black_List = DB::fetchAll('black_list');
        $user = $request->getAttribute('user');
        $passengerId=$user['passenger_id'];

        $blackListbypassengerId = array_filter($black_List, function ($black) use ($passengerId) {
            return $black['passenger_id'] == $passengerId;
        });
        $blacktime = count($blackListbypassengerId);
        $isBlack = (count($blackListbypassengerId) >= 3) ? TRUE : FALSE;
        //var_dump($blacktime);
        if ($isBlack = (count($blackListbypassengerId) >= 3)) {
            //thispassenger = '是黑名單';
            render('/ublack', [
            ]);
        } else {
            //thispassenger = '不是黑名單';

        $user = $request->getAttribute('user');
        $passengerId=$user['passenger_id'];
        //$passengerId = 2;
        $conn = DB::getconnection();
        $stmt = $conn->prepare("SELECT direction,unusal,g.getoff_id,stop_name,r.route_name,g.bus_id from getoff g,stop s,
        route r,bus b where g.passenger_id=$passengerId and g.stop_id=s.stop_id and g.bus_id=b.bus_id
         and b.route_id=r.route_id");
        $stmt->execute();
        $a = $stmt->fetchAll(PDO::FETCH_ASSOC);

        render('getoff', [
            'msg' => '輸入要新增的預約下車的資料',
            'List' => $a,
            'userdata' =>$user
        ]);
        return $response;
    }})->add(new AuthMiddleware('passenger'));;
    $app->post('/getoff/add', function (Request $request, Response $response, $args) {
        //找出預約的車子
        $data = $request->getParsedBody();
        $user = $request->getAttribute('user');
        $passengerId=$user['passenger_id'];
        //$passengerId = 2;
        $stopname = $data['stop_name'];
        $stopOfCollect = DB::find('stop', $stopname, 'stop_name');
        $stop_id = $stopOfCollect['stop_id'];
        //var_dump($stopname, $stop_id);

        $routename = $data['route_name'];
        $routeOfColllect = DB::find('route', $routename, 'route_name');
        $route_id = $routeOfColllect['route_id'];
        //var_dump($routename, $route_id);


        $directionId = $data['direction'];
        $unusal = $data['unusal'] ?? "";
        $result = $conn = DB::getconnection();
        $stmt = $conn->prepare("INSERT INTO `getoff`(`passenger_id`, `bus_id`, `stop_id`, `unusal`) VALUES 
    ($passengerId,(SELECT bus_id from bus where route_id=$route_id and direction=$directionId),$stop_id,$unusal)");
        $stmt->execute();
        $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($a, JSON_UNESCAPED_UNICODE);
        render('getoff', ['msg' => $result ? '預約成功' : '預約失敗',
        'userdata' =>$user]);
        return $response;
    })->add(new AuthMiddleware('passenger'));;
    $app->post('/getoff/delete', function (Request $request, Response $response, $args) {
        //刪除預約上車
        $user = $request->getAttribute('user');
        $data = $request->getParsedBody();
        
        $getoff_id = $data['getoff_id'];
        
        $result = DB::delete('getoff', $getoff_id, 'getoff_id');
        render('getoff', ['msg' => $result ? '取消預約成功' : '取消預約失敗',
        'userdata' =>$user
        ]);
        return $response;
    })->add(new AuthMiddleware('passenger'));;


    /* =========================================================================
    * = myfavourite
    * =========================================================================
    **/
    $app->get('/', function (Request $request, Response $response, $args) { //顯示站名
        render('index', []);
        return $response;
    });

    $app->get('/myfavourite', function (Request $request, Response $response, $args) {
        //列出id=?的顧客所收藏的站牌及路線
        //$passengerId = $args['id'];
        $user = $request->getAttribute('user');

        $passengerId=$user['passenger_id'];
        //var_dump($passengerId);
        //$passengerId = 2;
        $conn = DB::getconnection();
        $stmt = $conn->prepare("SELECT stop_name,r.route_name,collect_id 
        from collect c,stop s,route r 
        where passenger_id=$passengerId and
         c.stop_id=s.stop_id and c.route_id=r.route_id ");
        $stmt->execute();
        $collect = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //echo json_encode($a, JSON_UNESCAPED_UNICODE);
        render('myfavourite', [
            'msg' => '輸入要新增修改的資料',
            'stopList' => $collect,
            'userdata' => $user
        ]);
        return $response;
    })->add(new AuthMiddleware('passenger'));;  

    $app->post('/myfavourite/delete', function (Request $request, Response $response, $args) {
        //刪除收藏站牌
        $user = $request->getAttribute('user');
        $data = $request->getParsedBody(); //$_POST
        $collectId = $data['id'];
        DB::delete('collect', $collectId, 'collect_id');
        header("Location:/myfavourite");
        render('myfavourite', [
            'msg' => '刪除成功',
            'userdata' => $user
        ]);
    })->add(new AuthMiddleware('passenger'));;  
    $app->post('/myfavourite/add', function (Request $request, Response $response, $args) {
        $user = $request->getAttribute('user');
        $data = $request->getParsedBody(); //$_POST
        $passengerId=$user['passenger_id'];
    
        $stopname = $data['stop_name'];
        $stopOfCollect = DB::find('stop', $stopname, 'stop_name');
        $stop_id = $stopOfCollect['stop_id'];

        $routename = $data['route_name'];
        $routeOfColllect = DB::find('route', $routename, 'route_name');
        $route_id = $routeOfColllect['route_id'];

        $data2 = [
            "passenger_id" => $passengerId,
            "stop_id" => $stop_id,
            "route_id" => $route_id,
        ];
        $result = DB::create('collect', $data2);
        //header("Location:/myfavourite");
        render('/myfavourite', ['
        msg' => $result ? '增加收藏站牌資訊成功' : '增加收藏站牌資訊失敗',
        'userdata' => $user
        ]);

        return $response;
    })->add(new AuthMiddleware('passenger'));;

    /*$app->get('/collect', function (Request $request, Response $response, $args) {
        $passengerId = 2;
        $collectlist=DB::find('collect',$passengerId,'passenger_id');
        render('collect', [
            'msg' => '輸入要新增修改的資料',
            'collectlist' => $collectlist,        
        ]);
        return $response;
        //->withHeader('Location','/myfavourite')->withStatus(301);
    });
    
    $app->post('/myfavourite/add', function (Request $request, Response $response, $args) {

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
        $response->getBody()->write($view);

        return $response;
    });

    $app->get('/login', function (Request $request, Response $response, $args) {

        //如有登入則跳回使用者頁面
        if($identity = $_SESSION['auth']['identity'] ?? ''){
            $response = $response->withHeader('Location', "/{$identity}");
        }

        $view = render('login');
        $response->getBody()->write($view);

        return $response;
    });
*/
$app->get('/user', function (Request $request, Response $response, $args) { //顯示站名
    render('user', []);
    return $response;
});
    /* =========================================================================
    * = 註冊登入
    * =========================================================================
    **/
    $app->get('/login', function (Request $request, Response $response, $args) { //顯示站名
        render('login', []);
        return $response;
    });
    $app->post('/login', function (Request $request, Response $response, $args) use ($app) {
        $data = $request->getParsedBody(); //$_POST
        $identity = $data['identity'] ?? '';
        $account = $data['account'] ?? '';
        $password = $data['password'] ?? '';
        //var_dump($identity,$account,$password);
        if ($id = Auth::login($account, $password, $identity)) {
            $_SESSION['auth'] = ['id' => $id, 'identity' => $identity];
        }
        
        //$response->getBody()->write(json_encode(['data'=>$data,'id'=>$id]));


        return $response->withHeader('Location', "/{$identity}");
    });

    $app->get('/logout', function (Request $request, Response $response, $args) use ($app) {

        unset($_SESSION['auth']);

        return $response->withHeader('Location', '/index');
    });
    //註冊
    $app->post('/signup/add', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();
        $result = DB::create('passenger', $data);
        //var_dump($data);
        render('/login', ['msg' => $result ? '註冊成功' : '註冊失敗',]);

        return $response;
    });

    /* =========================================================================
    * = User Group
    * =========================================================================
    **/
    $app->get('/passenger', function (Request $request, Response $response, $args) {

        $user = $request->getAttribute('user');

        $view = render('/index', ['user' => $user]);
        $response->getBody()->write($view);

        return $response;
    })->add(new AuthMiddleware('passenger'));

    $app->get('/driverlogin', function (Request $request, Response $response, $args) { //顯示站名
        render('driverlogin', []);
        return $response;
    });

    $app->get('/driver', function (Request $request, Response $response, $args) {

        $user = $request->getAttribute('user');

        $view = render('/manage', ['user' => $user]);
        $response->getBody()->write($view);

        return $response;
    })->add(new AuthMiddleware('driver'));
    /* =========================================================================
    * = DRIVER Group
    * =========================================================================
    **/

    /*$app->group('/driver', function (Group $group) {

        $group->get('', function (Request $request, Response $response, $args) {

            $user = $request->getAttribute('user');

            $view = render('user', ['user' => $user]);
            $response->getBody()->write($view);

            return $response;
        });

        $group->get('/driver/{id}', function (Request $request, Response $response, $args) {

            $driverId = $args['id'];

            //司機駕駛的公車
            $bus = DB::find('bus', $driverId, 'driver_id');
            $departTime = $bus['DEPART_TIME'];

            $body = $response->getBody();
            $body->write(countTimeToArriveNextStop($departTime));

            return $response;
        });
    })->add(new AuthMiddleware('driver'));;

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

    
    $app->get('/manage', function (Request $request, Response $response, $args) { //顯示站名
        render('/manage', []);
        return $response;
    });
    $app->get('/signup', function (Request $request, Response $response, $args) { //顯示站名
        render('signup', []);
        return $response;
    });
    $app->get('/planroute', function (Request $request, Response $response, $args) { //顯示站名
        render('/planroute', []);
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
        
        
        render('/planroute', [
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
};
$app->get('/addblack', function (Request $request, Response $response, $args) {

    $view = render('/addblack');
    $response->getBody()->write($view);
    return $response;
});