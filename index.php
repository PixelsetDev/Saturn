<?php

use Boa\App;
use Boa\Router\Router;

ob_start();
/**
 * @author      LMWN <contact@lmwn.co.uk>
 * @copyright   Copyright (c), 2021 LMWN & Lewis Milburn
 *
 * This file is a modified version of the demo router provided by https://github.com/bramus/router.
 */
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once __DIR__.'/Boa/Router.php';
$App = new App();
$Router = new Router();

// Error Handler
$Router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
    echo '404 Not Found';
});

$Router->set404('/api(/.*)?', function () {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: application/json');

    $jsonArray = [];
    $jsonArray['status'] = '404';
    $jsonArray['status_text'] = 'route not defined';

    echo json_encode($jsonArray);
});

// Before Router Middleware
$Router->before('GET', '/.*', function () {
    header('X-Powered-By: saturn/router');
});

// Homepage
$Router->get('/', function () {
    echo '<h1>Saturn</h1><p>Whoops, we were unable to locate a file to render for the homepage. Please allocate a homepage in the <a href="panel">Saturn Panel</a>.</p>';
});

// Thunderbirds are go!
$Router->run();

// EOF
ob_end_flush();
