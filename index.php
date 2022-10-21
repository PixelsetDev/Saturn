<?php
/**
 *  ██████   █████   ████████  ██    ██  ██████   ███   ██
 * ██       ██   ██     ██     ██    ██  ██   ██  ████  ██
 *  █████   ███████     ██     ██    ██  ██████   ██ ██ ██
 *      ██  ██   ██     ██     ██    ██  ██   ██  ██  ████
 * ██████   ██   ██     ██      ██████   ██   ██  ██   ███.
 *
 * WELCOME TO SATURN CMS.
 *
 * FOR HELP VISIT DOCS.SATURNCMS.NET
 *
 * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
 * @license     Apache 2.0
 *
 * @since       1.0.0
 *
 * @version     1.0.0
 */

use Saturn\PluginKit;

ob_start();
session_start();

// Load required files, kits and libraries
require_once __DIR__.'/Settings.php';
require_once __DIR__.'/Processes/Data.php';
require_once __DIR__.'/Processes/Boa/Boa.php';
require_once __DIR__.'/Kit/ClientKit/ClientKit.php';
require_once __DIR__.'/Kit/PluginKit/PluginKit.php';

$Plugins = new PluginKit();
$loaded = 0;
foreach (glob(__DIR__.'/Plugins/*/*.php') as $Filename) {
    if ($Plugins->GetPluginName($Filename) == $Plugins->GetFileName($Filename)) {
        require $Filename;
        $loaded++;
    }
}

// ALWAYS USE SECURE HTTPS WHERE POSSIBLE
// THIS OPTION IS HERE FOR LOCALHOST ONLY
if (DEBUG && DEBUG_INSECURE) {
    // Set API Location
    if (CUSTOM_API_LOCATION) {
        $API_LOCATION = 'http://'.CUSTOM_API_LOCATION;
    } else {
        $API_LOCATION = 'http://'.$_SERVER['HTTP_HOST'].'/API';
    }
} else {
    // Set API Location
    if (CUSTOM_API_LOCATION) {
        $API_LOCATION = 'https://'.CUSTOM_API_LOCATION;
    } else {
        $API_LOCATION = 'https://'.$_SERVER['HTTP_HOST'].'/API';
    }
    // Force HTTPS
    if($_SERVER["HTTPS"] != "on")
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit;
    }
}

// Start the Router
require_once __DIR__.'/Processes/Controllers/Router/Router.php';

ob_end_flush();
