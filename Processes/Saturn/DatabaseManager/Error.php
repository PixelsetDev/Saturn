<?php

/**
 * Saturn Database Manager - Error
 *
 * Handles errors with the database system.
 */

namespace Saturn\DatabaseManager;

class Error {
    public function Connection($e) {
        $ErrorCode = '500';
        $ErrorName = 'Internal Server Error';
        $ErrorDescription = 'Database Connection Failed';
        $ErrorMessage = $e->getMessage();
        require_once __DIR__ . '/../ViewManager/Error.php';
        exit;
    }
}