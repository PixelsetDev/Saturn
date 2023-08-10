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
            require_once __DIR__.'/MySQLiDB.php';
            $this->Database = new MySQLiDB();
        } elseif (DB_TYPE == 'PDO') {
            require_once __DIR__.'/PDODB.php';
            $this->Database = new PDODB();
        } else {
            $EH = new ErrorHandler();
            $EH->SaturnError(
                '500',
                'DBMS-1',
                'Database type not supported.',
                'The database type you have selected is not supported by Saturn. Please select a supported database type.',
                SATSYS_DOCS_URL.'/troubleshooting/errors/database#dbms-1'
            );
        }
    }

    public function Escape(string $string): string
    {
        return htmlspecialchars($string);
    }

    public function RowCount(): int
    {
        return $this->Database->num_rows;
    }

    public function Error(): string|null
    {
        return $this->Database->error;
    }

    public function Select(string $what, string $from, string|null $where, string $action, string|null $order = null, string|null $limit = null): array|object|int|null
    {
        if ($what != '*' && !str_contains($what, '`')) {
            $what = '`'.$what.'`';
        }

        $Result = $this->Database->Select($what, DB_PREFIX.$from, $where, $action, $order, $limit);

        return $Result;
    }

    public function Insert(string $into, string|null $columns, string|null $values): array|object|int|null
    {
        $Result = $this->Database->Insert(DB_PREFIX.$into, $columns, $values);

        return $Result;
    }
}
