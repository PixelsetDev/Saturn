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
        $Router = new Router();
        $RouteMain = new RouteMain($Router);
        $RoutePanel = new RoutePanel($Router);

        $RouteMain->Register();
        $RoutePanel->Register();
    }
}