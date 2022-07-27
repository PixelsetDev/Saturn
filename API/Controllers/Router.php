<?php
/*
 * WELCOME TO THE SATURN SERVER.
 *
 * FOR MORE INFORMATION ON HOW TO USE THE SERVER PLEASE VISIT DOCS.SATURNCMS.NET
 */

use Boa\App;
use Boa\Authentication\JWT;
use Boa\Router\Router;

ob_start();
/**
 * Saturn Server Router.
 * This file is a modified version of the demo router provided by https://github.com/bramus/router.
 *
 * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
 * @license     Apache 2.0
 * @since       1.0.0
 * @version     1.0.0
 */
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}
$App = new App();
$Router = new Router();

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

// Auth
$Router->get('/v1/authenticate', function () {
    require_once __DIR__ . '/Controllers/Authentication/Login.php';
    $Login = new \SaturnServer\Authentication\Login();
    $Data = $Login->DoLogin($_GET);

    echo $Data;
});

// Thunderbirds are go!
$Router->run();

// EOF
ob_end_flush();