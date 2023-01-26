<?php

/**
 * Saturn Database Manager - PDODB (PDO Database).
 *
 * Run queries on the database using the PHP Data Objects system.
 */

namespace Saturn\DatabaseManager;

use PDO;
use PDOException;

class PDODB
{
    private PDO $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET;

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, DB_OPTIONS);
        } catch (PDOException $e) {
            $Error = new Error();
            $Error->Connection($e);
        }
    }

    public function Select(string $what, string $from, string $where, string $action, string $order, string $limit) {
        echo -1;
    }
}
