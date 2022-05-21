<?php
    ob_start();
    /* Load Configuration */
    require_once __DIR__.'/../config.php';
    /* Important Functions */
    require_once __DIR__.'/processes/translation.php';
    require_once __DIR__.'/../theme.php';
    require_once __DIR__.'/processes/database/connect.php';
    require_once __DIR__.'/processes/security/security.php';
    require_once __DIR__.'/processes/error_handler.php';
    set_error_handler('errorHandlerError', E_ERROR);
    set_error_handler('errorHandlerWarning', E_WARNING);
    // Saturn Info
    $saturnInfo = json_decode(file_get_contents(__DIR__.'/../assets/saturn.json'));
    define('SATURN_VERSION', $saturnInfo->{'saturn'}->{'version'});
    define('SATURN_BRANCH', $saturnInfo->{'saturn'}->{'branch'});
    define('SATURN_STORAGE_DIRECTORY', $saturnInfo->{'saturn'}->{'storagedir'});
    unset($saturnInfo);
    date_default_timezone_set(CONFIG_SITE_TIMEZONE);
    /* Developer Tools */
    if (CONFIG_DEBUG) {
        error_reporting(E_ALL);
        log_console('SATURN][DEBUG', __('Error:DebugEnabled'));
    }
    /* Database: Required Files */
    require_once __DIR__.'/processes/database/get/announcement.php';
    require_once __DIR__.'/processes/database/get/articles.php';
    require_once __DIR__.'/processes/database/get/page.php';
    require_once __DIR__.'/processes/database/get/user_settings.php';
    require_once __DIR__.'/processes/database/get/user_statistics.php';
    require_once __DIR__.'/processes/database/get/user.php';
    require_once __DIR__.'/processes/database/update/user_statistics.php';
    /* Required Files */
    require_once __DIR__.'/processes/resource_loader/resource_loader.php';
    require_once __DIR__.'/processes/email.php';
    require_once __DIR__.'/processes/version_check.php';
    require_once __DIR__.'/processes/gui/alerts.php';
    /* Require HTTPS */
    if ($_SERVER['HTTPS'] != 'on' && SECURITY_USE_HTTPS) {
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        exit();
    }
    if (get_announcement_website_active()) {
        if (get_announcement_website_link() != null && get_announcement_website_link() != '') {
            echo alert(get_announcement_website_type(), '<span class="underline">'.get_announcement_website_title().':</span> '.get_announcement_website_message().' - '.__('General:MoreInfo').' <a href="'.get_announcement_website_link().'" class="underline">'.__('General:ClickHere').'</a>.', true);
        } else {
            echo alert(get_announcement_website_type(), '<span class="underline">'.get_announcement_website_title().':</span> '.get_announcement_website_message(), true);
        }
    }
    ob_end_flush();
