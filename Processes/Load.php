<?php

/**
 * Saturn
 *
 * This file loads all the scripts and libraries needed to run Saturn.
 */

// SETTINGS
require __DIR__ . '/../Settings/Settings.php';

// SECURITY MANAGER
require __DIR__ . '/SecurityManager/CSRF.php';
require __DIR__ . '/SecurityManager/Encryption.php';
require __DIR__ . '/SecurityManager/XSS.php';

// SESSION MANAGER
require __DIR__ . '/SessionManager/Start.php';
require __DIR__ . '/SessionManager/Checker.php';

// DATABASE MANAGER
require __DIR__ . '/DatabaseManager/Error.php';
if (DB_TYPE == 'PDO') {
    require __DIR__ . '/DatabaseManager/PDODB.php';
} else if (DB_TYPE == 'MySQLi') {
    require __DIR__ . '/DatabaseManager/MySQLiDB.php';
}

// ROUTER
require __DIR__ . '/HTTP/Response.php';
require __DIR__ . '/HTTP/Router.php';