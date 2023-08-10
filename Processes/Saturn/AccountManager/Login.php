<?php

/**
 * Saturn Account Manager - Login.
 *
 * Allows users to login to Saturn.
 */

use Saturn\DatabaseManager\DBMS;
use Saturn\ErrorHandler;
use Saturn\SecurityManager\CSRF;
use Saturn\SessionManager\Authenticate;

$DB = new DBMS();
$CSRF = new CSRF();

$Result = $DB->Select('*', 'user', "`username` = '".$DB->Escape($_POST['username'])."'", 'first:object');

if ($DB->RowCount() == 1) {
    if ($CSRF->Check()) {
        if ($DB->Error() == null) {
            if (password_verify($_POST['password'], $Result->password)) {
                $Authenticate = new Authenticate();
                $Authenticate->Generate($Result->username,$Result->uuid);
                header('Location: '.SATURN_ROOT.'/panel');
            }
        } else {
            $EH = new ErrorHandler();
            $EH->SaturnError(
                '500',
                $DB->Error(),
                'Database error',
                'There was a problem with the database query.',
                SATSYS_DOCS_URL.'/troubleshooting/errors/database#'.strtolower($DB->Error())
            );
        }
    } else {
        $EH = new ErrorHandler();
        $EH->SaturnError(
            '400',
            'SAT-2',
            'CSRF Mismatch',
            'The CSRF token was not accepted.',
            SATSYS_DOCS_URL.'/troubleshooting/errors/saturn#sat-2'
        );
    }
} else {
    header('Location: '.SATURN_ROOT.'/account/join?error=notfound');
}
exit;
