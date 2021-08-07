<?php

    ob_start();
    /* Load Configuration */
    require_once __DIR__.'/../../config.php';
    require_once __DIR__.'/../storage/core_checksum.php';
    require_once __DIR__.'/../../theme.php';
    date_default_timezone_set(CONFIG_SITE_TIMEZONE);
    /* Important Functions */
    require_once __DIR__.'/processes/database/connect.php';
    require_once __DIR__.'/processes/security/security.php';
    require_once __DIR__.'/processes/errorHandler.php';
    set_error_handler('errorHandlerError', E_ERROR);
    set_error_handler('errorHandlerWarning', E_WARNING);
    /* Developer Tools */
    if (CONFIG_DEBUG) {
        log_console('SATURN][DEBUG', 'Debug Mode is ENABLED. This is NOT recommended in production environments. You can disable this in your site configuration settings.');
    }
    /* Database: Required Files */
    require_once __DIR__.'/processes/database/get/activity.php';
    require_once __DIR__.'/processes/database/get/articles.php';
    require_once __DIR__.'/processes/database/get/notification.php';
    require_once __DIR__.'/processes/database/get/page.php';
    require_once __DIR__.'/processes/database/get/todo.php';
    require_once __DIR__.'/processes/database/get/user.php';
    require_once __DIR__.'/processes/database/get/user_settings.php';
    require_once __DIR__.'/processes/database/get/user_statistics.php';
    require_once __DIR__.'/processes/database/update/articles.php';
    require_once __DIR__.'/processes/database/update/notification.php';
    require_once __DIR__.'/processes/database/update/user.php';
    require_once __DIR__.'/processes/database/update/user_settings.php';
    require_once __DIR__.'/processes/database/create/notification.php';
    require_once __DIR__.'/processes/database/create/todo.php';
    require_once __DIR__.'/processes/database/create/user.php';
    require_once __DIR__.'/processes/database/create/page.php';
    /* Required Files */
    require_once __DIR__.'/processes/resource_loader/resource_loader.php';
    require_once __DIR__.'/processes/email.php';
    require_once __DIR__.'/processes/link.php';
    require_once __DIR__.'/processes/themes.php';
    require_once __DIR__.'/processes/redirect.php';
    require_once __DIR__.'/panel/theme.php';
    /* GUI */
    require_once __DIR__.'/processes/gui/dashboard.php';
    require_once __DIR__.'/processes/gui/alerts.php';
    require_once __DIR__.'/processes/gui/modals.php';
    require_once __DIR__.'/processes/gui/user_profile.php';
    /* Authenticate Session */
    if (!isset($_SESSION['id'])) {
        internal_redirect('/panel/account/signin/?signedout=true');
    } elseif (!isset($_SESSION['role_id'])) {
        internal_redirect('/panel/account/signin/?signedout=role');
    } elseif (!isset($_SESSION['user_key']) || ($_SESSION['user_key'] != get_user_key($_SESSION['id']))) {
        internal_redirect('/panel/system/error/?err=gss2');
    } else {
        $id = $_SESSION['id'];
        $uid = $_SESSION['id'];
    }
    ccv_validate_all();
    if (!activation_validate()) {
        echo '<div class="bg-yellow-100 border-l-4 border-yellow-500 hover:-translate-y-2">
                                    <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                        <h6 class="mb-2 font-semibold leading-5">[WARNING] Activation: Saturn is not activated, certain features may be unavailable. You can still use some features of Saturn unactivated. You can activate Saturn in your Admin Panel. <a href="https://docs.saturncms.net/activation" class="underline text-xs text-black" target="_blank">Get help.</a></h6>
                                    </div>
                                </div>';
        log_console('SATURN][ACTIVATION', 'Saturn is not activated, certain features may be unavailable. You can still use some features of Saturn unactivated. You can activate Saturn in your Admin Panel.');
    }
    update_user_last_seen($_SESSION['id'], date('Y-m-d H:i:s'));
    ob_end_flush();
