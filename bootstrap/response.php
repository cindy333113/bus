<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function ($request, $handler) {

    $response = $handler->handle($request);
    
    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

    return $response
    ->withHeader('Access-Control-Allow-Credentials', 'true')
    ->withHeader('Access-Control-Allow-Origin', $origin)
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
    ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
    ->withAddedHeader('Cache-Control', 'post-check=0, pre-check=0')
    ->withHeader('Pragma', 'no-cache');

};