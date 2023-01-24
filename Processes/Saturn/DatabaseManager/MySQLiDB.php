<?php

/**
 * Saturn Database Manager - MySQLiDB (MySQLi Database)
 *
 * Run queries on the database using the PHP Data Objects system.
 */

namespace Saturn\DatabaseManager;

use Exception;
use mysqli;

class MySQLiDB {
    public function __construct()
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        if ($mysqli->connect_errno) {
            throw new Exception("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
    }
}