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
    private mysqli $mysqli;

    public function __construct()
    {
        try {
            $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        } catch (mysqli_sql_exception $e) {
            $Error = new Error();
            $Error->Connection($e);
        }
    }

    public function Select(string $what, string $from, string $where, string $action, string $order, string $limit): array|object|int|null
    {
        echo 5;
        $query = "SELECT `" . $what . "` FROM `" . $from . "`";

        if ($where != null) {
            $query .= ' WHERE ' . $where;
        }

        if ($order != null) {
            $query .= ' ORDER BY ' . $order;
        }

        if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }

        echo 6;
        $result = $this->mysqli->query($query);
        echo 7;

        if ($result) {
            if ($action == 'assoc') {
                return $result->fetch_assoc();
            } elseif ($action == 'all') {
                return $result->fetch_all();
            } elseif ($action == 'array') {
                return $result->fetch_array();
            } elseif ($action == 'object') {
                return $result->fetch_object();
            } elseif ($action == 'num_rows') {
                echo 8;
                return $result->num_rows;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
