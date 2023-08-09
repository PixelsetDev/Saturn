<?php

namespace Saturn\RouteManager;

use Saturn\HTTP\Router;

class Routes
{
    public function Register(): void
    {
        $Router = new Router();

        global $Actions;
        $Actions->Run('RouteRegister');

        require_once __DIR__.'/RouteMain.php';
        $RouteMain = new RouteMain($Router);
        $RouteMain->Register();

        require_once __DIR__.'/RouteAPI.php';
        $RouteAPI = new RouteAPI($Router);
        $RouteAPI->Register();

        echo '404 - Page not found.';
    }
}
