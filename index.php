<?php

ob_start();
/**
 * @author      LMWN <contact@lmwn.co.uk>
 * @copyright   Copyright (c), 2021 LMWN & Lewis Milburn
 * @license     Apache License
 *
 * This file is a modified version of the demo router provided by https://github.com/bramus/router.
 */
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}
require_once __DIR__.'/assets/common/global_public.php';
require_once $_SERVER['DOCUMENT_ROOT'].CONFIG_INSTALL_URL.'/router.php';
$router = new \Saturn\Router\Router();

// Error Handler
$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
    require_once $_SERVER['DOCUMENT_ROOT'].CONFIG_INSTALL_URL.'/assets/common/processes/error/404.php';
});

// Panel 404
$router->set404('/panel(/.*)?', function () {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
    echo 'PANEL: Error 404';
});

$router->set404('/api(/.*)?', function () {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: application/json');

    $jsonArray = [];
    $jsonArray['status'] = '404';
    $jsonArray['status_text'] = 'route not defined';

    echo json_encode($jsonArray);
});

// Before Router Middleware
$router->before('GET', '/.*', function () {
    header('X-Powered-By: saturn/router');
});

$router->get('/panel', function () {
    require_once __DIR__.'/panel/index.php';
});

$result = $conn->query('SELECT `url`  FROM `'.DATABASE_PREFIX.'pages` WHERE 1 ORDER BY `id` DESC');

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        foreach ($row as $page_uri) {
            $router->get($page_uri, function () {
                $pageuri = $_SERVER['REQUEST_URI'];
                require_once __DIR__.'/assets/common/processes/render_engine/pages.php';
            });
        }
    }
}

// Homepage
$router->get('/', function () {
    echo '<h1>saturn/router</h1><p>Router started.</p>';
});

// Subrouting
$router->mount('/articles', function () use ($router) {

    // will result in '/movies'
    $router->get('/', function () {
        echo 'Articles overview';
    });

    // will result in '/movies'
    $router->post('/', function () {
        echo 'Add article';
    });

    // will result in '/movies/id'
    $router->get('/(\d+)', function ($id) {
        echo 'Article id '.htmlentities($id);
    });

    // will result in '/movies/id'
    $router->put('/(\d+)', function ($id) {
        echo 'Update movie id '.htmlentities($id);
    });
});

// Thunderbirds are go!
$router->run();

// EOF
ob_end_flush();
