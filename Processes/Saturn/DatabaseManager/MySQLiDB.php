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
    private mysqli $MySQLi;
    public int $num_rows;
    public string|null $error;

    public function __construct()
    {
        try {
            $this->MySQLi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        } catch (mysqli_sql_exception $e) {
            $Error = new Error();
            $Error->Connection($e);
        }
    }

    public function Select(string $What, string $From, string $Where, string $Action, string|null $Order = null, string|null $Limit = null): array|object|int|null
    {
        if ($What !== '*') {
            $Query = 'SELECT `'.$What.'` FROM `'.$From.'`';
        } else {
            $Query = 'SELECT * FROM `'.$From.'`';
        }

        if ($Where != null) {
            $Query .= ' WHERE '.$Where;
        }

        if ($Order != null) {
            $Query .= ' ORDER BY '.$Order;
        }

        if ($Limit != null) {
            $Query .= ' LIMIT '.$Limit;
        }

        $Result = $this->MySQLi->query($Query);

        $this->error = null;

        if ($Result) {
            if ($Result->num_rows == 0) {
                $this->num_rows = 0;

                return null;
            }

            if ($Action === 'all:assoc') {
                $ActionResult = $Result->fetch_all(MYSQLI_ASSOC);
            } elseif ($Action === 'all:num') {
                $ActionResult = $Result->fetch_all();
            } elseif ($Action === 'first:assoc') {
                $ActionResult = $Result->fetch_array(MYSQLI_ASSOC);
            } elseif ($Action === 'first:num') {
                $ActionResult = $Result->fetch_array(MYSQLI_NUM);
            } elseif ($Action === 'first:object') {
                $ActionResult = $Result->fetch_object();
            } elseif ($Action === 'all:raw') {
                $ActionResult = $Result;
            } else {
                $ActionResult = false;
                $this->error = 'DBMS-2';
            }
        } else {
            $ActionResult = false;
            $this->error = 'DBMS-3';
        }

        $this->num_rows = $Result->num_rows;

        return $ActionResult;
    }

    public function Insert(string $Into, string $Columns, string $Values): array|object|int|null
    {
        return $this->MySQLi->query('INSERT INTO `'.$Into.'` ('.$Columns.') VALUES ('.$Values.')');
    }
}
