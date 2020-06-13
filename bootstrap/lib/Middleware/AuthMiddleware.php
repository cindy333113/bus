<?php

declare(strict_types=1);

namespace Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Auth;
use DB;

class AuthMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $id = $_SESSION['auth'] ?? '';
        $user = Auth::authenticate($id);

        $request = $request->withAttribute('user',$user);
        $response = $handler->handle($request);

        if(!$user){
            $response = $response->withHeader('Location', '/login');
        }
        
        return $response;
    }
}
