<?php

namespace Saturn\RouteManager;

use Saturn\HTTP\Router;

class RouteMain {
    public Router $Router;

    public function __construct(Router $Router)
    {
        $this->Router = $Router;
    }

    public function Register(): void
    {
        if (WEBSITE_MODE == 1 /*|| (WEBSITE_MODE == 0 && AUTH)*/) {
            // Homepage
            $this->Router->GET('/', 'Saturn/ViewManager/NoHomepage.php');
        } elseif (WEBSITE_MODE == 0) {
            $this->Router->GET('/', '/../Theme/' . THEME_SLUG . '/Maintenance.php');
        }

        return;
    }
}