<?php

/**
 * Saturn Database Manager - Error.
 *
 * Handles errors with the database system.
 */

namespace Saturn\DatabaseManager;

class Error
{
    public function Connection($Error): void
    {
        $ErrorCode = '500';
        $ErrorName = 'Internal Server Error';
        $ErrorDescription = 'Database Connection Failed';
        $ErrorMessage = '['.$Error->getCode().'] '.$Error->getMessage();

        require_once __DIR__.'/../../DefaultViews/Error.php';
        exit;
    }
}
