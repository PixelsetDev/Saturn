<?php

namespace SaturnServer\User;

use Boa\Database\SQL;

class UserData
{
    /**
     * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
     * @license     Apache 2.0
     *
     * @since       1.0.0
     *
     * @version     1.0.0
     *
     * @return mixed
     */
    public function GetFullName($Username) {
        $SQL = new SQL();

        $Name = $SQL->Select('`firstname`, `lastname`', DATABASE_PREFIX.'users', '`username` = \''.$Username.'\'', 'ALL:ASSOC');
        return $Name[0]['firstname'].' '.$Name[0]['lastname'];
    }
}