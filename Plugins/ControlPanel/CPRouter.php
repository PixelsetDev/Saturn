<?php

namespace ControlPanel;

use Saturn\AccountManager\Permissions;
use Saturn\DatabaseManager\DBMS;
use Saturn\HTTP\Router;
use Saturn\SessionManager\Authenticate;

class CPRouter
{
    private Router $Router;
    private Permissions $Permissions;
    public function Register(Router $Router): void
    {
        $this->Router = $Router;
        $this->Permissions = new Permissions($_SESSION['UUID']);

        require_once __DIR__.'/../../Processes/Saturn/SessionManager/Authenticate.php';
        $Authenticate = new Authenticate();

        if (isset($_SESSION['Username']) && isset($_SESSION['Token']) && $Authenticate->Validate()) {
            $this->Account(true);
            $this->Panel(true);
        } else {
            $this->Account(false);
            $this->Panel(false);
        }
    }

    private function Account(bool $Authenticated): void
    {
        if ($Authenticated) {
            $this->Router->GET(CPURL_Account, '../Plugins/ControlPanel/Views/Account.php');
            $this->Router->GET(CPURL_Account.CPURL_Join, '../Plugins/ControlPanel/Views/Account.php');
            $this->Router->GET(CPURL_Account.CPURL_Logout, '../Processes/Saturn/AccountManager/Logout.php');
        } else {
            $this->Router->GET('/account', CPPage_Login);
            $this->Router->GET('/account/join', '../Plugins/ControlPanel/Views/Join.php');
            $this->Router->GET('/account/logout', '../Processes/Saturn/AccountManager/Logout.php');
        }
    }

    private function Panel(bool $Authenticated): void
    {
        if ($Authenticated) {
            if ($this->Permissions->HasPermission(['administrator', 'panel_access'], 'OR')) {
                if ($this->Permissions->HasPermission(['administrator', 'panel_pages_edit'], 'OR')) {
                    $this->Pages(true);
                } else {
                    $this->Pages(false);
                }

                if ($this->Permissions->HasPermission(['administrator', 'panel_settings'], 'OR')) {
                    $this->Settings(true);
                } else {
                    $this->Settings(false);
                }

                $this->PanelAccess(true);
            } else {
                $this->PanelAccess(false);
            }
        } else {
            $this->Router->GET('/panel/alert', CPPage_Login);
            $this->Router->GET('/panel/edit', CPPage_Login);
            $this->Router->GET('/panel', CPPage_Login);
        }
    }

    private function Settings(bool $HasPermission): void
    {
        if ($HasPermission) {
            $this->Router->GET(CPURL_Panel.CPURL_Plugins, '../Plugins/ControlPanel/Views/Plugins.php');
            $this->Router->GET(CPURL_Panel.CPURL_Users, '../Plugins/ControlPanel/Views/Users.php');
            global $SaturnPlugins;
            foreach ($SaturnPlugins as $Plugin => $Loaded) {
                $this->Router->GET(CPURL_Panel.CPURL_Plugins.'/'.$Plugin, '../Plugins/ControlPanel/Views/Plugin.php');
            }
            $DBMS = new DBMS();
            $Users = $DBMS->Select('*', 'user', '1', 'all:assoc');
            foreach ($Users as $User) {
                $this->Router->GET(CPURL_Panel.CPURL_Users.'/'.$User['uuid'], '../Plugins/ControlPanel/Views/User.php');
            }
        } else {
            $this->Router->GET(CPURL_Panel.CPURL_Plugins, CPPage_NoAccess);
            $this->Router->GET(CPURL_Panel.CPURL_Users, CPPage_NoAccess);
        }
    }

    private function Pages(bool $HasPermission): void
    {
        if ($HasPermission) {
            $this->Router->GET(CPURL_Panel.CPURL_Edit, '../Plugins/ControlPanel/Views/Edit.php');
        } else {
            $this->Router->GET(CPURL_Panel.CPURL_Edit, CPPage_NoAccess);
        }
    }

    private function PanelAccess(bool $HasPermission): void
    {
        if ($HasPermission) {
            $this->Router->GET(CPURL_Panel, '../Plugins/ControlPanel/Views/Panel.php');
            $this->Router->GET(CPURL_Panel.'/alert', '../Plugins/ControlPanel/Views/Alert.php');
            $this->Router->GET(CPURL_Panel.'/api/statistics', '../Plugins/ControlPanel/API/Statistics.php');
        } else {
            $this->Router->GET(CPURL_Panel.'/api/statistics', CPPage_NoAccess);
            $this->Router->GET(CPURL_Panel.'/alert', CPPage_NoAccess);
            $this->Router->GET(CPURL_Panel.CPURL_Edit, CPPage_NoAccess);
            $this->Router->GET(CPURL_Panel, CPPage_NoAccess);
        }
    }
}
