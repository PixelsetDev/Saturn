<?php
/*
 * WELCOME TO THE SATURN SERVER.
 *
 * FOR MORE INFORMATION ON HOW TO USE THE SERVER PLEASE VISIT DOCS.SATURNCMS.NET
 */

use Boa\App;
use Boa\Router\Router;

ob_start();
/**
 * Saturn Server Router.
 * This file is a modified version of the demo router provided by https://github.com/bramus/router.
 *
 * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
 * @license     Apache 2.0
 *
 * @since       1.0.0
 *
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
    require_once __DIR__.'/Authentication/Login.php';
    $Login = new \SaturnServer\Authentication\Login();
    $Data = $Login->DoLogin($_GET);

    echo $Data;
});

// Pages
$Router->get('/v1/page/list', function () {
    require_once __DIR__.'/Page/Get.php';
    $GET = new \SaturnServer\Page\Get();
    echo json_encode($GET->List());
});
$Router->get('/v1/page/count', function () {
    require_once __DIR__.'/Page/Count.php';
    $Count = new \SaturnServer\Page\Count();
    echo $Count->CountTotalPages();
});

// Articles
$Router->get('/v1/article/count', function () {
    require_once __DIR__.'/Article/Count.php';
    $Count = new \SaturnServer\Article\Count();
    $Data = $Count->CountTotalArticles();

    if ($Data == null) {
        echo 0;
    } else {
        echo $Data;
    }
});

// Users
$Router->get('/v1/user/fullname', function () {
    require_once __DIR__.'/User/UserData.php';
    $UserData = new \SaturnServer\User\UserData();
    echo $UserData->GetFullName($_GET['username']);
});

// Actions
$Router->get('/v1/action/count/pending', function () {
    echo 'disabled';
});

// Thunderbirds are go!
$Router->run();

// EOF
ob_end_flush();
