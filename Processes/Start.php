<?php

/**
 * Saturn.
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
echo 1;
// DATABASE
if (DB_TYPE == 'PDO') {
    echo 2;
    $DB = new PDODB();
    echo 3;
} elseif (DB_TYPE == 'MySQLi') {
    echo 2;
    $DB = new MySQLiDB();
    echo 3;
} else {
    $ErrorHandler->Fatal('1', 'Database type not supported.', 'Start.php', '48');
}

// ROUTER
require __DIR__ . '/Router.php';
echo 4;
