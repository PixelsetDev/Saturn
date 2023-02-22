<?php

namespace ControlPanel;

use Saturn\HTTP\Router;

class CPRouter
{
    public function Register(Router $Router): void
    {
        if (str_contains($_SERVER['REQUEST_URI'], '/panel')) {
            $Router->GET('/panel', '../Plugins/ControlPanel/Views/Panel.php');
            $Router->GET('/account/login', '../Plugins/ControlPanel/Views/Login.php');
        }
    }
}