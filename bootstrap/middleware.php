<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

return function (App $app) {
    $app->add(function (Request $request, RequestHandler $handler) {
        $request = $request->withAttribute('session',Session::getInstance());
        $response = $handler->handle($request);
        return $response;
    });
};
