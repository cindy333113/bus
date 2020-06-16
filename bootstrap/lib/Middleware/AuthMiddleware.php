<?php

declare(strict_types=1);

namespace Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Auth;

class AuthMiddleware implements Middleware
{

    private $authIdentity;

    function __construct($authIdentity)
    {
        $this->$authIdentity = $authIdentity;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $auth = $_SESSION['auth'] ?? [];
        $authIdentity = $this->authIdentity;
        $user = Auth::authenticate($auth, $authIdentity);

        $request = $request->withAttribute('user',$user);
        $response = $handler->handle($request);

        if(!$user){
            $response = $response->withHeader('Location', '/login');
        }
        
        return $response;
    }
}
