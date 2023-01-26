<?php

/**
 * Saturn Form Manager - Panel Login.
 *
 * Handles errors with the database system.
 */

use Saturn\DatabaseManager\DBMS;
use Saturn\ErrorHandler;
use Saturn\SessionManager\Authenticate;

$DB = new DBMS();


$Result = $DB->Select('*', 'users', "`username` = '" . $DB->Escape($_POST['username'])."'", 'first:object');

if ($DB->num_rows() == 1) {
    if ($DB->error() == NULL) {
        if (password_verify($_POST['password'], $Result->password)) {
            $Authenticate = new Authenticate();
            $Authenticate->Login($Result->username);
            header('Location: /panel');
        }
    } else {
        $EH = new ErrorHandler();
        $EH->SaturnError('500',
            $DB->error(),
            'Database error',
            'There was a problem with the database query.',
            SATSYS_DOCS_URL.'/troubleshooting/errors/database#'.strtolower($DB->error()));
    }
} else {
    header('Location: '.WEBSITE_ROOT.'/account/?notfound');
}
exit;