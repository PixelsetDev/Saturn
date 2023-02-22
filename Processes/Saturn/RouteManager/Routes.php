<?php

namespace Saturn\RouteManager;

use Saturn\HTTP\Router;

class Routes
{
    public function Register(): void
    {
        $Router = new Router();

        if (str_contains($_SERVER['REQUEST_URI'], '/panel')) {
            require_once __DIR__.'/RoutePanel.php';

            $RoutePanel = new RoutePanel($Router);
            $RoutePanel->Register();
        } elseif (str_contains($_SERVER['REQUEST_URI'], '/account')) {
            require_once __DIR__.'/RouteAccount.php';

            $RouteAccount = new RouteAccount($Router);
            $RouteAccount->Register();
        } else {
            require_once __DIR__.'/RouteMain.php';

            $RouteMain = new RouteMain($Router);
            $RouteMain->Register();
        }
    }
}
