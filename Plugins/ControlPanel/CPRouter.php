<?php

namespace ControlPanel;

use Saturn\DatabaseManager\DBMS;
use Saturn\HTTP\Router;
use Saturn\SessionManager\Authenticate;
use Saturn\AccountManager\Permissions;

class CPRouter
{
    public function Register(Router $Router): void
    {
        require_once __DIR__.'/../../Processes/Saturn/SessionManager/Authenticate.php';
        $Authenticate = new Authenticate();

        if (isset($_SESSION['Username']) && isset($_SESSION['Token']) && $Authenticate->Validate()) {
            $Permissions = new Permissions($_SESSION['UUID']);

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

                if ($Permissions->HasPermission(['administrator','panel_settings'],'OR')) {
                    // Has access to editing pages
                    $Router->GET('/panel/plugins', '../Plugins/ControlPanel/Views/Plugins.php');
                    $Router->GET('/panel/users', '../Plugins/ControlPanel/Views/Users.php');
                    global $SaturnPlugins;
                    foreach ($SaturnPlugins as $Plugin => $Loaded) {
                        $Router->GET('/panel/plugins/'.$Plugin, '../Plugins/ControlPanel/Views/Plugin.php');
                    }
                    $DBMS = new DBMS();
                    $Users = $DBMS->Select('*','user','1','all:assoc');
                    foreach ($Users as $User) {
                        $Router->GET('/panel/users/'.$User['uuid'], '../Plugins/ControlPanel/Views/User.php');
                    }
                } else {
                    // Does not have access to editing pages
                    $Router->GET('/panel/plugins', '../Plugins/ControlPanel/Views/NoAccess.php');
                    $Router->GET('/panel/users', '../Plugins/ControlPanel/Views/NoAccess.php');
                }

                // Has access to control panel
                $Router->GET('/panel', '../Plugins/ControlPanel/Views/Panel.php');
                $Router->GET('/panel/alert', '../Plugins/ControlPanel/Views/Alert.php');
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

            $Router->GET('/panel/alert', '../Plugins/ControlPanel/Views/Login.php');
            $Router->GET('/panel/edit', '../Plugins/ControlPanel/Views/Login.php');
            $Router->GET('/panel', '../Plugins/ControlPanel/Views/Login.php');
        }
    }
}
