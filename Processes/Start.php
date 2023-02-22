<?php

/**
 * Saturn.
 *
 * This file starts up Saturn.
 */

use Saturn\ErrorHandler;
use Saturn\HookManager\Actions;
use Saturn\PluginManager\PluginLoader;
use Saturn\SecurityManager\XSS;
use Saturn\Translation;

// ACTIONS
$ActionList = [];
$Actions = new Actions();
$Actions->Run('Saturn.PreStart');

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
$PluginLoader->LoadAll();
$Actions->Run('Saturn.PluginManager.LoadedAll');

// ROUTER
require_once __DIR__.'/Router.php';
