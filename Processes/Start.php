<?php

/**
 * Saturn.
 *
 * This file starts up Saturn.
 */

use Saturn\ErrorHandler;
use Saturn\HookManager\Actions;
use Saturn\LanguageManager\Translation;
use Saturn\PluginManager\PluginLoader;
use Saturn\SecurityManager\XSS;
use Saturn\SessionManager\Session;

$Session = new Session();
$Session->Start();

register_shutdown_function('SaturnEnd');

function SaturnEnd(): void
{
    $Actions = new Actions();
    $Actions->Run('Saturn.End');
}

// ACTIONS
$ActionList = [];
$Actions = new Actions();

// ERROR HANDLER
$ErrorHandler = new ErrorHandler();
$ErrorHandler->Register();

// FUNCTIONS
function Out(string $Text): string
{
    $XSS = new XSS();

    return $XSS->Escape($Text);
}

function __(string $Text): string
{
    $Translation = new Translation();
    $XSS = new XSS();

    $text = $Translation->Translate($Text);

    return $XSS->Escape($Text);
}

if (WEBSITE_ENV == 1) {
    error_reporting(E_ERROR);
} elseif (WEBSITE_ENV == 0) {
    error_reporting(E_ALL);
} else {
    $EH = new ErrorHandler();
    $EH->SaturnError(
        '500',
        'SAT-1',
        'Unknown website environment.',
        'Please check your settings and try again.',
        SATSYS_DOCS_URL.'/troubleshooting/errors/saturn#sat-1'
    );
}

// PLUGINS
$SaturnPlugins = [];
$Actions->Run('Saturn.PluginManager.PreLoad');
$PluginLoader = new PluginLoader();
$PluginLoader->Load();
$Actions->Run('Saturn.PluginManager.PostLoad');

$Actions->Run('Saturn.PostStart');

// ROUTER
require_once __DIR__.'/Router.php';

exit;
