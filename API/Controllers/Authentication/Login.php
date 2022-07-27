<?php

namespace SaturnServer\Authentication;

use Boa\Database\SQL;

class Login
{
    /**
     * Saturn Server
     * Login and authenticate users.
     *
     * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
     * @license     Apache 2.0
     *
     * @since       1.0.0
     *
     * @version     1.0.0
     */
    public function __construct()
    {
    }

    /**
     * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
     * @license     Apache 2.0
     *
     * @since       1.0.0
     *
     * @version     1.0.0
     *
     * @param $data
     *
     * @return bool|string
     */
    public function DoLogin($data): bool|string
    {
        if (isset($data['username']) && isset($data['password'])) {
            $Username = urldecode($data['username']);
            $SQL = new SQL();
            $JWT = new \Boa\Authentication\JWT(JWT_SECRET, JWT_ISSUER);

            $User = $SQL->Select('Password', DATABASE_PREFIX.'Users', '`username` = \''.$Username.'\'', 'ALL:ASSOC');
            $User = $User[0];
            if ($User['Password'] == null) {
                $Response['response']['code'] = '401';
                $Response['response']['status'] = 'Unauthorised';
                $Response['response']['message'] = 'Username or Password was Incorrect';
            } else {
                if (hash_equals($User['Password'], $_GET['password'])) {
                    $Response['response']['code'] = '200';
                    $Response['response']['status'] = 'OK';
                    $Response['response']['message'] = 'Authorised';
                    $Response['token'] = $JWT->Generate('PAYLOAD');
                } else {
                    $Response['response']['code'] = '401';
                    $Response['response']['status'] = 'Unauthorised';
                    $Response['response']['message'] = 'Username or Password was Incorrect';
                }
            }
        } else {
            $Response['response']['code'] = '401';
            $Response['response']['status'] = 'Unauthorised';
            $Response['response']['message'] = 'Username or Password was Incorrect';
        }

        return json_encode($Response);
    }
}
