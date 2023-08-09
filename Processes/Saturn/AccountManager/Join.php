<?php

/**
 * Saturn Form Manager - Account Join.
 *
 * Handles errors with the database system.
 */

use Saturn\AccountManager\UUID;
use Saturn\DatabaseManager\DBMS;
use Saturn\ErrorHandler;
use Saturn\SecurityManager\CSRF;

require_once __DIR__ . '/UUID.php';

$DB = new DBMS();
$CSRF = new CSRF();
$UUID = new UUID();

$Result = $DB->Select('*', 'user', "`username` = '".$DB->Escape($_POST['username'])."'", 'first:object');

if ($DB->num_rows() == 0) {
    if ($CSRF->Check()) {
        $Username = $DB->Escape($_POST['username']);
        $Email = $DB->Escape($_POST['email']);
        $Password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $Result = $DB->Insert('users', '`id`, `uuid`, `username`, `email`, `password`', "NULL, '".$UUID->Generate()."', '".$Username."', '".$Email."', '".$Password."'");
        if ($DB->error() == null) {
            header('Location: /account?success=created');
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
    header('Location: '.SATURN_ROOT.'/account/join?error=exists');
}
exit;