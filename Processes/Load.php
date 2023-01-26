<?php

/**
 * Saturn.
 *
 * This file loads all the scripts and libraries needed to run Saturn.
 */

// SYSTEM
require __DIR__.'/Saturn/System.php';

if (PHP_VERSION < SATURN_MINIMUM_PHP) {
    echo 'Saturn requires PHP '.SATURN_MINIMUM_PHP.' or newer. You are using PHP '.PHP_VERSION.'.';
    exit;
}

// SETTINGS
require __DIR__.'/../Settings/Settings.php';
require __DIR__.'/../Settings/Theme.php';

// ERROR HANDLER
require __DIR__.'/Saturn/ErrorHandler.php';

// SECURITY MANAGER
require __DIR__.'/Saturn/SecurityManager/CSRF.php';
require __DIR__.'/Saturn/SecurityManager/Encryption.php';
require __DIR__.'/Saturn/SecurityManager/XSS.php';

// SESSION MANAGER
require __DIR__.'/Saturn/SessionManager/Start.php';
require __DIR__.'/Saturn/SessionManager/Checker.php';

// TRANSLATION
require __DIR__.'/Saturn/Translation.php';

// DATABASE MANAGER
require __DIR__.'/Saturn/DatabaseManager/Error.php';
if (DB_TYPE == 'PDO') {
    require __DIR__.'/Saturn/DatabaseManager/PDODB.php';
} elseif (DB_TYPE == 'MySQLi') {
    require __DIR__.'/Saturn/DatabaseManager/MySQLiDB.php';
}

// ROUTER
require __DIR__.'/Saturn/HTTP/Response.php';
require __DIR__.'/Saturn/HTTP/Router.php';
