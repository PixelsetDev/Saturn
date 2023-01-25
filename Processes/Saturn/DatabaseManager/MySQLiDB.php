<?php

/**
 * Saturn Database Manager - MySQLiDB (MySQLi Database).
 *
 * Run queries on the database using the PHP Data Objects system.
 */

namespace Saturn\DatabaseManager;

use mysqli;
use mysqli_sql_exception;

class MySQLiDB
{
    public mysqli $mysqli;

    public function __construct()
    {
        try {
            $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        } catch (mysqli_sql_exception $e) {
            $Error = new Error();
            $Error->Connection($e);
        }
    }
}
