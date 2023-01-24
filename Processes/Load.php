<?php

/**
 * Saturn
 *
 * This file loads all the scripts and libraries needed to run Saturn.
 */

// ERROR HANDLER
require __DIR__ . '/Saturn/ErrorHandler.php';

// SETTINGS
require __DIR__ . '/../Settings/Settings.php';

// SECURITY MANAGER
require __DIR__ . '/Saturn/SecurityManager/CSRF.php';
require __DIR__ . '/Saturn/SecurityManager/Encryption.php';
require __DIR__ . '/Saturn/SecurityManager/XSS.php';

// SESSION MANAGER
require __DIR__ . '/Saturn/SessionManager/Start.php';
require __DIR__ . '/Saturn/SessionManager/Checker.php';

// TRANSLATION
require __DIR__ . '/Saturn/Translation.php';

// DATABASE MANAGER
require __DIR__ . '/Saturn/DatabaseManager/Error.php';
if (DB_TYPE == 'PDO') {
    require __DIR__ . '/Saturn/DatabaseManager/PDODB.php';
} else if (DB_TYPE == 'MySQLi') {
    require __DIR__ . '/Saturn/DatabaseManager/MySQLiDB.php';
}

// ROUTER
require __DIR__ . '/Saturn/HTTP/Response.php';
require __DIR__ . '/Saturn/HTTP/Router.php';