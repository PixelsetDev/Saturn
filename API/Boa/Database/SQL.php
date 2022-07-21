<?php

/**
 * Boa SQL Library
 * @author      Lewis Milburn <contact@lewismilburn.com>
 * @license     Apache-2.0 License
 */

namespace Boa\Database;

use Boa\App;
use mysqli;
use mysqli_result;

class SQL extends App
{
    /**
     * @var mysqli
     */
    private mysqli $DBect;
    public array $settings;

    public function __construct()
    {
        // Construct parent class.
        parent::__construct();

        // Settings
        $this->settings = array (
            'database_hostname' => DATABASE_HOSTNAME,
            'database_username' => DATABASE_USERNAME,
            'database_password' => DATABASE_PASSWORD,
            'database_database' => DATABASE_DATABASE,
            'database_port' => DATABASE_PORT,
            'database_socket' => DATABASE_SOCKET,
            'database_security' => true
        );

        // Connect to the database.
        $this->connect = new mysqli($this->settings['database_hostname'], $this->settings['database_username'], $this->settings['database_password'], $this->settings['database_database'], $this->settings['database_port'], $this->settings['database_socket']);

        // Return the connection.
        return $this->connect;
    }

    public function Select($select, $from, $where = '1', $mode = 'NONE') {
        $DB = $this->connect;

        if ($select != '*' && !str_contains($select, '`')) { $result = $DB->query("SELECT `$select` FROM `$from` WHERE $where;"); }
        else { $result = $DB->query("SELECT $select FROM `$from` WHERE $where;"); }

        if ($result->num_rows > 0) {
            return match ($mode) {
                'NONE' => $result,
                'ALL' => $result->fetch_all(),
                'ALL:ASSOC' => $result->fetch_all(MYSQLI_ASSOC),
                'ALL:NUMERIC' => $result->fetch_all(MYSQLI_NUM),
                'ALL:BOTH' => $result->fetch_all(MYSQLI_BOTH),
                'ASSOC' => $result->fetch_assoc(),
                'ARRAY' => $result->fetch_array(),
                'OBJECT' => $result->fetch_object(),
                'NUMROWS' => $result->num_rows,
                default => 'Mode defined incorrectly.',
            };
        } else {
            return null;
        }
    }

    public function Insert($table, $items, $values): mysqli_result|bool
    {
        $DB = $this->connect;
        return $DB->query("INSERT INTO `$table` ($items) VALUES ($values);");
    }

    public function Update($table, $set, $where): mysqli_result|bool
    {
        $DB = $this->connect;
        return $DB->query("UPDATE '$table' SET $set WHERE $where;");
    }

    public function Delete($table, $where): mysqli_result|bool
    {
        $DB = $this->connect;
        return $DB->query("DELETE FROM '$table' WHERE $where;");
    }

    public function Escape($data)
    {
        $DB = $this->connect;
        return $DB->escape_string($data);
    }
}