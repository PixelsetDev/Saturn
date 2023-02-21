<?php

namespace Saturn\RouteManager;

use Saturn\HTTP\Router;

class RoutePanel
{
    public Router $Router;

    public function __construct(Router $Router)
    {
        $this->Router = $Router;
    }

    public function Register(): void
    {
    }
}
