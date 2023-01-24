<?php

/**
 * Saturn
 *
 * This file starts up Saturn.
 */

use Saturn\DatabaseManager\MySQLiDB;
use Saturn\DatabaseManager\PDODB;

// DATABASE
if (DB_TYPE == 'PDO') {
    $DB = new PDODB();
} else if (DB_TYPE == 'MySQLi') {
    $DB = new MySQLiDB();
}

// ROUTER
require __DIR__ . '/Router.php';