<?php

/**
 * Saturn Database Manager - DBMS (Database Management System).
 *
 * Run queries on the selected database format.
 */

namespace Saturn\DatabaseManager;

use Saturn\ErrorHandler;

class DBMS
{
    private PDODB|MySQLiDB $Database;

    public function __construct()
    {
        if (DB_TYPE == 'MySQLi' || DB_TYPE == 'MySQL') {
            $this->Database = new MySQLiDB();
        } elseif (DB_TYPE == 'PDO') {
            $this->Database = new PDODB();
        } else {
            $EH = new ErrorHandler();
            $EH->SaturnError('500',
                'DBMS-1',
                'Database type not supported.',
                'The database type you have selected is not supported by Saturn. Please select a supported database type.',
                SATSYS_DOCS_URL.'/troubleshooting/errors/database#dbms-1');
        }
    }

    public function Escape(string $string): string
    {
        return htmlspecialchars($string);
    }

    public function Select(string $what, string $from, string|null $where, string $action, string|null $order = null, string|null $limit = null): array|object|int|null
    {
        echo 3;
        if ($what != '*' && !str_contains($what, '`')) {
            $what = '`' . $what . '`';
        }
        echo 4;

        $DB = new MySQLiDB();

        var_dump($DB->Select($what, $from, $where, $action, $order, $limit));
        echo $DB->Select($what, $from, $where, $action, $order, $limit);
    }
}