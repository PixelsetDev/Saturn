<?php

namespace ControlPanel;

use Saturn\HTTP\Router;
use Saturn\SessionManager\Authenticate;

class CPRouter
{
    public function Register(Router $Router): void
    {
        require_once __DIR__.'/../../Processes/Saturn/SessionManager/Authenticate.php';

        $Authenticate = new Authenticate();

        if (isset($_SESSION['username']) && isset($_SESSION['token']) && $Authenticate->Authenticated($_SESSION['username'], $_SESSION['token'])) {
            $Router->GET('/panel', '../Plugins/ControlPanel/Views/Panel.php');

            $Router->GET('/account', '../Plugins/ControlPanel/Views/Account.php');
            $Router->GET('/account/join', '../Plugins/ControlPanel/Views/Account.php');

            $Router->GET('/panel/edit', '../Plugins/ControlPanel/Views/Edit.php');
        } else {
            $Router->GET('/panel', '../Plugins/ControlPanel/Views/Login.php');

            $Router->GET('/account', '../Plugins/ControlPanel/Views/Login.php');
            $Router->GET('/account/join', '../Plugins/ControlPanel/Views/Join.php');

            $Router->GET('/panel/edit', '../Plugins/ControlPanel/Views/Edit.php');
        }
    }
}
