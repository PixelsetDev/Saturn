<?php

namespace ControlPanel;

use Saturn\AccountManager\Permissions;
use Saturn\DatabaseManager\DBMS;
use Saturn\HTTP\Router;
use Saturn\SessionManager\Authenticate;

class CPRouter
{
    public function Register(Router $Router): void
    {
        require_once __DIR__.'/../../Processes/Saturn/SessionManager/Authenticate.php';
        $Authenticate = new Authenticate();

        if (isset($_SESSION['Username']) && isset($_SESSION['Token']) && $Authenticate->Validate()) {
            $Permissions = new Permissions($_SESSION['UUID']);

            // Logged in
            $Router->GET(CPURL_Account, '../Plugins/ControlPanel/Views/Account.php');
            $Router->GET(CPURL_Account.CPURL_Join, '../Plugins/ControlPanel/Views/Account.php');
            $Router->GET(CPURL_Account.CPURL_Logout, '../Processes/Saturn/AccountManager/Logout.php');

            if ($Permissions->HasPermission(['administrator', 'panel_access'], 'OR')) {
                if ($Permissions->HasPermission(['administrator', 'panel_pages_edit'], 'OR')) {
                    // Has access to editing pages
                    $Router->GET(CPURL_Panel.CPURL_Edit, '../Plugins/ControlPanel/Views/Edit.php');
                } else {
                    // Does not have access to editing pages
                    $Router->GET(CPURL_Panel.CPURL_Edit, CPPage_NoAccess);
                }

                if ($Permissions->HasPermission(['administrator', 'panel_settings'], 'OR')) {
                    // Has access to editing pages
                    $Router->GET(CPURL_Panel.CPURL_Plugins, '../Plugins/ControlPanel/Views/Plugins.php');
                    $Router->GET(CPURL_Panel.CPURL_Users, '../Plugins/ControlPanel/Views/Users.php');
                    global $SaturnPlugins;
                    foreach ($SaturnPlugins as $Plugin => $Loaded) {
                        $Router->GET(CPURL_Panel.CPURL_Plugins.'/'.$Plugin, '../Plugins/ControlPanel/Views/Plugin.php');
                    }
                    $DBMS = new DBMS();
                    $Users = $DBMS->Select('*', 'user', '1', 'all:assoc');
                    foreach ($Users as $User) {
                        $Router->GET(CPURL_Panel.CPURL_Users.'/'.$User['uuid'], '../Plugins/ControlPanel/Views/User.php');
                    }
                } else {
                    // Does not have access to editing pages
                    $Router->GET(CPURL_Panel.CPURL_Plugins, CPPage_NoAccess);
                    $Router->GET(CPURL_Panel.CPURL_Users, CPPage_NoAccess);
                }

                // Has access to control panel
                $Router->GET('/panel', '../Plugins/ControlPanel/Views/Panel.php');
                $Router->GET('/panel/alert', '../Plugins/ControlPanel/Views/Alert.php');
                $Router->GET('/panel/api/statistics', '../Plugins/ControlPanel/API/Statistics.php');
            } else {
                // Does not have access to control panel
                $Router->GET('/panel/edit', CPPage_NoAccess);
                $Router->GET('/panel', CPPage_NoAccess);
            }
        } else {
            // Not logged in
            $Router->GET('/account', CPPage_Login);
            $Router->GET('/account/join', '../Plugins/ControlPanel/Views/Join.php');
            $Router->GET('/account/logout', '../Processes/Saturn/AccountManager/Logout.php');

            $Router->GET('/panel/alert', CPPage_Login);
            $Router->GET('/panel/edit', CPPage_Login);
            $Router->GET('/panel', CPPage_Login);
        }
    }
}
