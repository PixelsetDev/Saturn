<?php

namespace Saturn\RouteManager;

use Saturn\Saturn\HTTP\Router;

class RouteMain {
    public Router $Router;

    public function __construct(Router $Router)
    {
        $this->Router = $Router;
    }

    public function Register(): void
    {
        // Homepage
        $this->Router->GET('/', 'Saturn/ViewManager/Error.php');
    }
}