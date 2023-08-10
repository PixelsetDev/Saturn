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
    public int $num_rows;
    public string|null $error;

    public function __construct()
    {
        try {
            $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        } catch (mysqli_sql_exception $e) {
            $Error = new Error();
            $Error->Connection($e);
        }
    }

    public function Select(string $what, string $from, string $where, string $action, string|null $order = null, string|null $limit = null): array|object|int|null
    {
        if ($what != '*') {
            $query = 'SELECT `'.$what.'` FROM `'.$from.'`';
        } else {
            $query = 'SELECT * FROM `'.$from.'`';
        }

        if ($where != null) {
            $query .= ' WHERE '.$where;
        }

        if ($order != null) {
            $query .= ' ORDER BY '.$order;
        }

        if ($limit != null) {
            $query .= ' LIMIT '.$limit;
        }

        $result = $this->mysqli->query($query);

        $this->error = null;

        if ($result) {
            if ($action == 'all:assoc') {
                $actionResult = $result->fetch_all(MYSQLI_ASSOC);
            } elseif ($action == 'all:num') {
                $actionResult = $result->fetch_all();
            } elseif ($action == 'first:assoc') {
                $actionResult = $result->fetch_array(MYSQLI_ASSOC);
            } elseif ($action == 'first:num') {
                $actionResult = $result->fetch_array(MYSQLI_NUM);
            } elseif ($action == 'first:object') {
                $actionResult = $result->fetch_object();
            } elseif ($action == 'all:raw') {
                $actionResult = $result;
            } else {
                $actionResult = false;
                $this->error = 'DBMS-2';
            }
        } else {
            $actionResult = false;
            $this->error = 'DBMS-3';
        }

        $this->num_rows = $result->num_rows;

        return $actionResult;
    }

    public function Insert(string $into, string $columns, string $values): array|object|int|null
    {
        return $this->mysqli->query('INSERT INTO `'.$into.'` ('.$columns.') VALUES ('.$values.')');
    }
}
