<?php

use Boa\App;
use Boa\Router\Router;

ob_start();
/**
 * ------ SATURN ROUTER ------
 * This file controls the routing of users around your website's pages.
 *
 * @author      LMWN <contact@lmwn.co.uk>
 * @copyright   Copyright (c), 2021 LMWN & Lewis Milburn
 *
 * This file is a modified version of the demo router provided by https://github.com/bramus/router.
 */
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$App = new App();
$Router = new Router();

// Error Handler
$Router->set404(function () {
    //header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
    echo '404';
});

// Before Router Middleware
$Router->before('GET', '/.*', function () {
    header('X-Powered-By: Boa/Router');
});

// Homepage
$Router->get('/', function () {
    echo '<h1>Saturn</h1><p>Whoops, we were unable to locate a file to render for the homepage. Please allocate a homepage in the <a href="panel">Saturn Panel</a>.</p>';
});

// Panel
$Router->mount('/panel', function () use ($Router) {
    $Router->get('/', function () {
        if (isset($_SESSION['token'])) {
            require_once __DIR__.'/../../../Views/Panel/Dashboard/Dashboard.php';
        } else {
            require_once __DIR__.'/../../../Views/Panel/Account/Login.php';
        }
    });
    $Router->post('/', function () {
        require_once __DIR__.'/../../Controllers/Panel/Account/Login.php';
    });
    // Register
    $Router->get('/register', function () {
        require_once __DIR__.'/../../../Views/Panel/Account/Register.php';
    });

    // Reset
    $Router->get('/reset', function () {
        require_once __DIR__.'/../../../Views/Panel/Account/Register.php';
    });

    // Pages
    $Router->get('/pages', function () {
        require_once __DIR__.'/../../../Views/Panel/Pages/List.php';
    });

    // Page Editor
    $Router->get('/pages/edit', function () {
        require_once __DIR__.'/../../../Views/Panel/Pages/Editor.php';
    });
});

// Account
$Router->mount('/account', function () use ($Router) {
    $Router->get('/', function () {
        if (isset($_SESSION['token']) && !isset($_GET['Error'])) {
            require_once __DIR__.'/../../../Views/Panel/Account/Overview.php';
        } else {
            require_once __DIR__.'/../../../Views/Panel/Account/Login.php';
        }
    });
    $Router->post('/', function () {
        require_once __DIR__.'/../../Controllers/Panel/Account/Login.php';
    });
    // Register
    $Router->get('/register', function () {
        require_once __DIR__.'/../../../Views/Panel/Account/Register.php';
    });
    // Sign out
    $Router->get('/signout', function () {
        session_unset();
        session_destroy();
        header('Location: /account');
    });
    // Reset
    $Router->get('/reset', function () {
        require_once __DIR__.'/../../../Views/Panel/Account/Reset.php';
    });
});

// Thunderbirds are go!
$Router->run();

// EOF
ob_end_flush();
