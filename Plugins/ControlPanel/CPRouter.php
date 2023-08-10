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
            $this->Router->GET(CPURL_ACCOUNT, '../Plugins/ControlPanel/Views/Account.php');
            $this->Router->GET(CPURL_ACCOUNT.CPURL_JOIN, '../Plugins/ControlPanel/Views/Account.php');
            $this->Router->GET(CPURL_ACCOUNT.CPURL_LOGOUT, '../Processes/Saturn/AccountManager/Logout.php');
        } else {
            $this->Router->GET('/account', CPPAGE_LOGIN);
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
            $this->Router->GET('/panel/alert', CPPAGE_LOGIN);
            $this->Router->GET('/panel/edit', CPPAGE_LOGIN);
            $this->Router->GET('/panel', CPPAGE_LOGIN);
        }
    }

    private function Settings(bool $HasPermission): void
    {
        if ($HasPermission) {
            $this->Router->GET(CPURL_PANEL.CPURL_PLUGINS, '../Plugins/ControlPanel/Views/Plugins.php');
            $this->Router->GET(CPURL_PANEL.CPURL_USERS, '../Plugins/ControlPanel/Views/Users.php');
            global $SaturnPlugins;
            foreach ($SaturnPlugins as $Plugin => $Loaded) {
                $this->Router->GET(CPURL_PANEL.CPURL_PLUGINS.'/'.$Plugin, '../Plugins/ControlPanel/Views/Plugin.php');
            }
            $DBMS = new DBMS();
            $Users = $DBMS->Select('*', 'user', '1', 'all:assoc');
            foreach ($Users as $User) {
                $this->Router->GET(CPURL_PANEL.CPURL_USERS.'/'.$User['uuid'], '../Plugins/ControlPanel/Views/User.php');
            }
        } else {
            $this->Router->GET(CPURL_PANEL.CPURL_PLUGINS, CPPAGE_NOACCESS);
            $this->Router->GET(CPURL_PANEL.CPURL_USERS, CPPAGE_NOACCESS);
        }
    }

    private function Pages(bool $HasPermission): void
    {
        if ($HasPermission) {
            $this->Router->GET(CPURL_PANEL.CPURL_EDIT, '../Plugins/ControlPanel/Views/Edit.php');
        } else {
            $this->Router->GET(CPURL_PANEL.CPURL_EDIT, CPPAGE_NOACCESS);
        }
    }

    private function PanelAccess(bool $HasPermission): void
    {
        if ($HasPermission) {
            $this->Router->GET(CPURL_PANEL, '../Plugins/ControlPanel/Views/Panel.php');
            $this->Router->GET(CPURL_PANEL.'/alert', '../Plugins/ControlPanel/Views/Alert.php');
            $this->Router->GET(CPURL_PANEL.'/api/statistics', '../Plugins/ControlPanel/API/Statistics.php');
        } else {
            $this->Router->GET(CPURL_PANEL.'/api/statistics', CPPAGE_NOACCESS);
            $this->Router->GET(CPURL_PANEL.'/alert', CPPAGE_NOACCESS);
            $this->Router->GET(CPURL_PANEL.CPURL_EDIT, CPPAGE_NOACCESS);
            $this->Router->GET(CPURL_PANEL, CPPAGE_NOACCESS);
        }
    }
}
