<?php

/**
 * Saturn Account Manager - Permissions.
 *
 * Manages user permissions.
 */

namespace Saturn\AccountManager;

use Saturn\DatabaseManager\DBMS;
use Saturn\ErrorHandler;

class Permissions
{
    public object|null $Permissions;

    public function __construct($UUID)
    {
        $DB = new DBMS();
        $Result = $DB->Select('*', 'user_permissions', "`uuid` = '".$DB->Escape($UUID)."'", 'first:object');
        $this->Permissions = $Result;
    }

    public function HasPermission(array $RequestedPermissions, string $Operation): bool
    {
        if ($this->Permissions == null) {
            return false;
        }

        if ($Operation === 'OR') {
            foreach ($RequestedPermissions as $RP) {
                if (property_exists($this->Permissions, $RP)) {
                    if ($this->Permissions->$RP == 1) {
                        return true;
                    }
                }
            }
        } else {
            $EH = new ErrorHandler();
            $EH->SaturnError(
                '500',
                'SAT-5',
                'Operation not supported.',
                'The requested operation: '.$Operation.' is not supported. Supported operations are: OR',
                SATSYS_DOCS_URL.'/troubleshooting/errors/saturn#sat-5'
            );
        }

        return false;
    }
}
