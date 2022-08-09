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

// Load required files, kits and libraries
require_once __DIR__.'/Settings.php';
require_once __DIR__.'/Processes/Data.php';
require_once __DIR__.'/Processes/Boa/Boa.php';
require_once __DIR__.'/Kit/ClientKit/ClientKit.php';
require_once __DIR__.'/Kit/PluginKit/PluginKit.php';

// Set API Location
// ALWAYS USE SECURE HTTPS WHERE POSSIBLE
// THIS OPTION IS HERE FOR LOCALHOST ONLY
if (DEBUG && DEBUG_INSECURE) {
    if (CUSTOM_API_LOCATION) {
        $API_LOCATION = 'http://'.CUSTOM_API_LOCATION;
    } else {
        $API_LOCATION = 'http://'.$_SERVER['HTTP_HOST'].'/API';
    }
} else {
    if (CUSTOM_API_LOCATION) {
        $API_LOCATION = 'https://'.CUSTOM_API_LOCATION;
    } else {
        $API_LOCATION = 'https://'.$_SERVER['HTTP_HOST'].'/API';
    }
}

// Start the Router
require_once __DIR__.'/Processes/Controllers/Router/Router.php';
