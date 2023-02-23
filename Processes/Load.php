<?php

/**
 * Saturn.
 *
 * This file loads all the scripts and libraries needed to run Saturn.
 */

// SYSTEM
require_once __DIR__.'/Saturn/System.php';

if (PHP_VERSION < SATSYS_MINIMUM_PHP) {
    echo 'Saturn require_onces PHP '.SATSYS_MINIMUM_PHP.' or newer. You are using PHP '.PHP_VERSION.'.';
    exit;
}

// SETTINGS
require_once __DIR__.'/../Settings/Panel.php';
require_once __DIR__.'/../Settings/Settings.php';
require_once __DIR__.'/../Settings/Theme.php';

// HOOK MANAGER
require_once __DIR__.'/Saturn/HookManager/Actions.php';

// ERROR HANDLER
require_once __DIR__.'/Saturn/ErrorHandler.php';

// SECURITY MANAGER
require_once __DIR__.'/Saturn/SecurityManager/CSRF.php';
require_once __DIR__.'/Saturn/SecurityManager/Encryption.php';
require_once __DIR__.'/Saturn/SecurityManager/XSS.php';

// SESSION MANAGER
require_once __DIR__.'/Saturn/SessionManager/Start.php';
require_once __DIR__.'/Saturn/SessionManager/Checker.php';

// TRANSLATION
require_once __DIR__.'/Saturn/Translation.php';

// DATABASE MANAGER
require_once __DIR__.'/Saturn/DatabaseManager/Error.php';
require_once __DIR__.'/Saturn/DatabaseManager/DBMS.php';

// ROUTER
require_once __DIR__.'/Saturn/HTTP/Response.php';
require_once __DIR__.'/Saturn/HTTP/Router.php';

// PLUGIN MANAGER
require_once __DIR__.'/Saturn/PluginManager/PluginLoader.php';
require_once __DIR__ . '/Saturn/PluginManager/PluginLoadOrder.php';
require_once __DIR__.'/Saturn/PluginManager/PluginManifest.php';
