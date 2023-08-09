<?php

namespace ControlPanel;

use Saturn\HTTP\Router;
use Saturn\SessionManager\Authenticate;
use Saturn\AccountManager\Permissions;

class CPRouter
{
    public function Register(Router $Router): void
    {
        require_once __DIR__.'/../../Processes/Saturn/SessionManager/Authenticate.php';
        $Authenticate = new Authenticate();

        if (isset($_SESSION['username']) && isset($_SESSION['token']) && $Authenticate->Authenticated($_SESSION['username'], $_SESSION['token'])) {
            $Permissions = new Permissions($_SESSION['uuid']);

            // Logged in
            $Router->GET('/account', '../Plugins/ControlPanel/Views/Account.php');
            $Router->GET('/account/join', '../Plugins/ControlPanel/Views/Account.php');
            $Router->GET('/account/logout', '../Processes/Saturn/AccountManager/Logout.php');

            if ($Permissions->HasPermission(['administrator','panel_access'],'OR')) {
                if ($Permissions->HasPermission(['administrator','panel_pages_edit'],'OR')) {
                    // Has access to editing pages
                    $Router->GET('/panel/edit', '../Plugins/ControlPanel/Views/Edit.php');
                } else {
                    // Does not have access to editing pages
                    $Router->GET('/panel/edit', '../Plugins/ControlPanel/Views/NoAccess.php');
                }

                // Has access to control panel
                $Router->GET('/panel', '../Plugins/ControlPanel/Views/Panel.php');
                $Router->GET('/panel/api/statistics', '../Plugins/ControlPanel/API/Statistics.php');
            } else {
                // Does not have access to control panel
                $Router->GET('/panel/edit', '../Plugins/ControlPanel/Views/NoAccess.php');
                $Router->GET('/panel', '../Plugins/ControlPanel/Views/NoAccess.php');
            }
        } else {
            // Not logged in
            $Router->GET('/account', '../Plugins/ControlPanel/Views/Login.php');
            $Router->GET('/account/join', '../Plugins/ControlPanel/Views/Join.php');
            $Router->GET('/account/logout', '../Processes/Saturn/AccountManager/Logout.php');

            $Router->GET('/panel/edit', '../Plugins/ControlPanel/Views/Login.php');
            $Router->GET('/panel', '../Plugins/ControlPanel/Views/Login.php');
        }
    }
}
