<?php
    /* Load Configuration */
    require_once __DIR__.'/../../config.php';
    require_once __DIR__.'/../../theme.php';
    /* Important Functions */
    require_once __DIR__ . '/processes/database/connect.php';
    require_once __DIR__ . '/processes/security/security.php';
    require_once __DIR__ . '/processes/errorHandler.php';
    set_error_handler("errorHandlerError", E_ERROR);
    set_error_handler("errorHandlerWarning", E_WARNING);
    /* Developer Tools */
    if(CONFIG_DEBUG == true) {if (CONFIG_DEBUG == true) {log_console('SATURN][DEBUG', 'Debug Mode is ENABLED. This is NOT recommended in production environments. You can disable this in your site configuration settings.');}}
    if(CONFIG_PHP_ERRORS == true) {error_reporting(E_ALL, ~E_NOTICE);} else {error_reporting(0);}
    /* Database: Required Files */
    /* require_once __DIR__.'/processes/database/get/page.php'; */
    /* Required Files */
    require_once __DIR__.'/vendors.php';
    require_once __DIR__ . '/processes/resource_loader/resource_loader.php';
    require_once __DIR__ . '/processes/email.php';