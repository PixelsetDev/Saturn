<?php

namespace Saturn\RouteManager;

use Saturn\HTTP\Router;

class RouteMain
{
    public Router $Router;

    public function __construct(Router $Router)
    {
        $this->Router = $Router;
    }

    public function Register(): void
    {
        if (WEBSITE_MODE == 0 /*|| (WEBSITE_MODE == 1 && AUTH)*/) {
            // Homepage
            $this->Router->GET('/', 'DefaultViews/NoHomepage.php');
        } elseif (WEBSITE_MODE == 1) {
            $this->Router->GET('/', '/../Themes/'.THEME_SLUG.'/Maintenance.php');
        }
    }
}
