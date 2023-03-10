<?php

namespace Saturn\RouteManager;

use Saturn\HTTP\Router;

class RouteAPI
{
    public Router $Router;

    public function __construct(Router $Router)
    {
        $this->Router = $Router;
    }

    public function Register(): void
    {
        $this->Router->POST('/API/Login', '/Saturn/AccountManager/Login.php');
        $this->Router->POST('/API/Join', '/Saturn/AccountManager/Join.php');
    }
}
