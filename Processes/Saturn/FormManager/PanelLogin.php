<?php

/**
 * Saturn Form Manager - Panel Login.
 *
 * Handles errors with the database system.
 */

use Saturn\DatabaseManager\DBMS;
echo 1;
$DB = new DBMS();
echo 2;

var_dump($DB->Select('*', 'users', 'username = ' . $DB->Escape($_POST['username']), 'num_rows'));