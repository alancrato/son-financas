<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use SONFin\Application;
use SONFin\Plugins\RoutePlugin;
use SONFin\ServiceContainer;
use Zend\Diactoros\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());

$app->get('/', function() {
    echo "Hello World!";
});

$app->get('/params/{name}/{id}', function(ServerRequestInterface $request) {
    $response = new Response();
    $response->getBody()->write("Response the emmiter to Diactoros");
    return $response;
});

$app->get('/route', function (RequestInterface $request){
   var_dump($request->getUri());die();
   echo "New Route";
});

$app->start();