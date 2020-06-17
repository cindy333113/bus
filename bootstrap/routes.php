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
            'msg' => 'hello',
        ]);

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

    $app->post('/login', function (Request $request, Response $response, $args) use ($app) {

        $data = $request->getParsedBody(); //$_POST

        $identity = $data['identity'] ?? '';
        $account = $data['account'] ?? '';
        $password = $data['password'] ?? '';

        if ($id = Auth::login($account, $password, $identity)) {
            $_SESSION['auth'] = ['id' => $id, 'identity' => $identity];
        }

        return $response->withHeader('Location', "/{$identity}");
    });

    $app->post('/logout', function (Request $request, Response $response, $args) use ($app) {

        unset($_SESSION['auth']);

        return $response->withHeader('Location', '/');
    });

    /* =========================================================================
    * = User Group
    * =========================================================================
    **/
    $app->get('/passenger', function (Request $request, Response $response, $args) {

        $user = $request->getAttribute('user');

        $view = render('user', ['user' => $user]);
        $response->getBody()->write($view);

        return $response;
    })->add(new AuthMiddleware('passenger'));

    /* =========================================================================
    * = DRIVER Group
    * =========================================================================
    **/

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
        
    })->add(new AuthMiddleware('driver'));;

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

        render('stop', ['msg' => $result ? '增加站牌資訊成功' : '增加站牌資訊失敗',]);

        return $response;
    });

    $app->post('/stop/update', function (Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $stopId = $data['STOP_ID'];

        $result = DB::update('stop', "`STOP_ID` = {$stopId}", $data);

        render('stop', ['msg' => $result ? '修改站牌資訊成功' : '修改站牌資訊失敗',]);

        return $response;
    });
};
