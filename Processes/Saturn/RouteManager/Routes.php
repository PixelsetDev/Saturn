<?php

namespace Saturn\RouteManager;

use Saturn\Saturn\HTTP\Router;

class Routes {
    public function __construct()
    {
        require_once __DIR__ . '/RouteMain.php';
        require_once __DIR__ . '/RoutePanel.php';
    }

    public function Register(): void
    {
        $Router = new Router();echo 1;

        $RouteMain = new RouteMain($Router);echo 1;
        $RoutePanel = new RoutePanel($Router);
        echo 1;
        $RouteMain->Register();
        echo 1;
        $RoutePanel->Register();
        echo 1;
    }
}