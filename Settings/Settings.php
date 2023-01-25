<?php

/**
 * Saturn Settings.
 *
 * DO NOT EDIT THIS FILE IN A TEXT EDITOR
 */

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//           //  If you edit this file in a text editor Saturn will display a warning saying the installation  //
//  WARNING  //  is not secure. This is because Saturn validates it against a checksum created whenever you    //
//           //  edit this file in the admin panel.                                                            //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// WEBSITE
const WEBSITE_NAME = 'Saturn';
const WEBSITE_LANGUAGE = 'en';
const WEBSITE_ROOT = '';

// DATABASE
const DB_TYPE = 'MySQLi';
const DB_HOST = 'localhost';
const DB_NAME = 'Saturn';
const DB_USER = 'root';
const DB_PASS = 'B$o?MrR}zLe9';
const DB_PORT = 3306;
const DB_CHARSET = 'utf8mb4';
const DB_OPTIONS = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
