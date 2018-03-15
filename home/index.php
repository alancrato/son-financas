<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use SONFin\Application;
use SONFin\Plugins\DbPlugin;
use SONFin\Plugins\RoutePlugin;
use SONFin\Plugins\ViewPlugin;
use SONFin\ServiceContainer;
use Zend\Diactoros\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());

/*$app->get('/{name}', function(ServerRequestInterface $request) use ($app) {
    $view = $app->service('view.renderer');
    return $view->render('test.html.twig', ['name' => $request->getAttribute('name')]);
});*/

$app->get('/params/{name}/{id}', function(ServerRequestInterface $request) {
    $response = new Response();
    $response->getBody()->write("Response the emmiter to Diactoros");
    return $response;
});

$app->get('/', function(RequestInterface $request){
    $request->getUri();
    return "Welcome to page index";
});

$app
    ->get('/category-costs', function() use($app){
        $meuModel = new \SONFin\Models\CategoryCosts();
        $categories = $meuModel->all();
        $view = $app->service('view.renderer');
        return $view->render('category-costs/list.html.twig',[
            'categories' => $categories
        ]);
    },'category-costs.list')
    ->get('/category-costs/new', function() use($app){
        $view = $app->service('view.renderer');
        return $view->render('category-costs/create.html.twig');
    },'category-costs.new')
    ->post('/category-costs/store', function(ServerRequestInterface $request) use ($app){
        $data = $request->getParsedBody();
        SONFin\Models\CategoryCosts::create($data);
        return $app->route('category-costs.list');
    },'category-costs.store')
    ->get('/category-costs/{id}/edit', function(ServerRequestInterface $request) use($app){
        $view = $app->service('view.renderer');
        $id = $request->getAttribute('id');
        $category = \SONFin\Models\CategoryCosts::findOrFail($id);
        return $view->render('category-costs/edit.html.twig', [
            'category' => $category
        ]);
    },'category-costs.edit')
    ->post('/category-costs/{id}/update', function(ServerRequestInterface $request) use($app){
        $id = $request->getAttribute('id');
        $category = \SONFin\Models\CategoryCosts::findOrFail($id);
        $data = $request->getParsedBody('id');
        $category->fill($data);
        $category->save();
        return $app->route('category-costs.list');
    },'category-costs.update');

$app->get('/route', function (RequestInterface $request){
   var_dump($request->getUri());die();
   echo "New Route";
});

$app->start();