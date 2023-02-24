<?php

/**
 * Saturn Form Manager - Panel Login.
 *
 * Handles errors with the database system.
 */

use Saturn\DatabaseManager\DBMS;
use Saturn\ErrorHandler;
use Saturn\SecurityManager\CSRF;
use Saturn\SessionManager\Authenticate;

$DB = new DBMS();
$CSRF = new CSRF();

$Result = $DB->Select('*', 'users', "`username` = '".$DB->Escape($_POST['username'])."'", 'first:object');

if ($DB->num_rows() == 1) {
    if ($CSRF->Check()) {
        if ($DB->error() == null) {
            if (password_verify($_POST['password'], $Result->password)) {
                $Authenticate = new Authenticate();
                $Authenticate->Login($Result->username);
                header('Location: '.SATURN_ROOT.'/panel');
            }
        } else {
            $EH = new ErrorHandler();
            $EH->SaturnError(
                '500',
                $DB->error(),
                'Database error',
                'There was a problem with the database query.',
                SATSYS_DOCS_URL.'/troubleshooting/errors/database#'.strtolower($DB->error())
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
    header('Location: '.SATURN_ROOT.'/account/not-found');
}
exit;
