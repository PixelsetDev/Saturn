<?php

/**
 * Saturn
 *
 * This file starts up Saturn.
 */

use Saturn\DatabaseManager\MySQLiDB;
use Saturn\DatabaseManager\PDODB;
use Saturn\ErrorHandler;
use Saturn\SecurityManager\XSS;
use Saturn\Translation;

// ERROR HANDLER
$ErrorHandler = new ErrorHandler();
$ErrorHandler->Register();

// FUNCTIONS
function out(string $text): string
{
    $XSS = new XSS();
    return $XSS->out($text);
}

function __(string $text): string
{
    $Translation = new Translation();
    $XSS = new XSS();

    $text = $Translation->Translate($text);
    return $XSS->out($text);
}

// DATABASE
if (DB_TYPE == 'PDO') {
    $DB = new PDODB();
} else if (DB_TYPE == 'MySQLi') {
    $DB = new MySQLiDB();
}

// ROUTER
require __DIR__ . '/Router.php';