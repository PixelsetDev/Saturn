<?php

/*
 * WELCOME TO THE SATURN API.
 *
 * FOR MORE INFORMATION ON HOW TO USE THE API PLEASE VISIT DOCS.SATURNCMS.NET
 */

use Boa\App;
use Boa\Router\Router;

ob_start();
/**
 * @author      LMWN <contact@lmwn.co.uk>
 * @copyright   Copyright (c), 2021 LMWN & Lewis Milburn
 *
 * This file is a modified version of the demo router provided by Boa.
 */
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once __DIR__.'/Boa/Boa.php';
require_once __DIR__.'/Settings/Load.php';
$App = new App();
$Router = new Router();

$jsonArray = [];

$Router->set404('(/.*)?', function () {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: application/json');

    $jsonArray['status'] = '404';
    $jsonArray['response'] = 'Route not defined';
    echo json_encode($jsonArray);
});

// Before Router Middleware
$Router->before('GET', '/.*', function () {
    header('X-Powered-By: Boa/Router');
});

// Homepage
$Router->get('/', function () {
    $jsonArray['status'] = '200';
    $jsonArray['response'] = 'Saturn API';
    echo json_encode($jsonArray);
});

// Thunderbirds are go!
$Router->run();

// EOF
ob_end_flush();
