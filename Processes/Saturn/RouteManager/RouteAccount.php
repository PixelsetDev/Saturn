<?php

namespace Saturn\RouteManager;

use Saturn\HTTP\Router;

class RouteAccount
{
    public Router $Router;

    public function __construct(Router $Router)
    {
        $this->Router = $Router;
    }

    public function Register(): void
    {
        // Login
        $this->Router->GET('/account', 'Saturn/ViewManager/Panel/Authenticate.php');
        $this->Router->POST('/account', 'Saturn/FormManager/PanelLogin.php');
        // Register
        $this->Router->GET('/account/join', 'Saturn/ViewManager/Panel/Register.php');
        $this->Router->POST('/account/join', 'Saturn/FormManager/PanelRegister.php');
    }
}
