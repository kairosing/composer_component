<?php
if( !session_id() ) @session_start();

require "../vendor/autoload.php";
use App\QueryBuilder;



$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/home', ['App\controllers\HomeController', 'index']);
    $r->addRoute('GET', '/about', ['App\controllers\HomeController', 'about']);

    $r->addRoute('GET', '/create', ['App\controllers\HomeController', 'create_user']);
    $r->addRoute('POST', '/create/new', ['App\controllers\HomeController', 'create_user_handler']);

    $r->addRoute('GET', '/action/{id:\d+}', ['App\controllers\HomeController', 'action_user']);

     $r->addRoute('GET', '/edit/{id:\d+}', ['App\controllers\HomeController', 'edit']);
     $r->addRoute('POST', '/edit/user', ['App\controllers\HomeController', 'edit_user']);

    $r->addRoute('GET', '/delete/{id:\d+}', ['App\controllers\HomeController', 'delete_user']);
    // The /{title} suffix is optional
    //$r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found не туда попали
        echo '404';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed метод не разрышен
        echo '405';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $controller = new $handler[0];

        call_user_func([$controller, $handler[1]], $vars);
        // ... call $handler with $vars
        break;
}
