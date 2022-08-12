<?php

namespace Saturn\ClientKit;

use Boa\App;
use Boa\Database\SQL;

class Authentication
{
    public function DoLogin($Username, $Password): int|array
    {
        require_once __DIR__.'/../../Processes/Boa/Boa.php';

        new App();
        $SQL = new SQL();

        $User = $SQL->Select('*', $SQL->Escape(DATABASE_PREFIX).'users', '`username` = \''.$SQL->Escape($Username).'\' OR `email` = \''.$SQL->Escape($Username).'\'', 'ALL:ASSOC');

        if (!isset($User[0]['id'])) {
            return 1;
        }

        if (!isset($User[1]['id'])) {
            if (password_verify($Password, $User[0]['password'])) {
                return $User;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }
}
