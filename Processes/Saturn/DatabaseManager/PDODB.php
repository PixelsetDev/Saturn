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
    private PDO $PDO;

    public function __construct()
    {
        $DSN = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET;

        try {
            $this->PDO = new PDO($DSN, DB_USER, DB_PASS, DB_OPTIONS);
        } catch (PDOException $e) {
            $Error = new Error();
            $Error->Connection($e);
        }
    }

    public function Select(string $What, string $From, string $Where, string $Action, string $Order, string $Limit)
    {
        echo -1;
    }
}
