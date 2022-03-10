<?php
    session_start();
    ob_start();
    require_once __DIR__.'/../../../common/global_private.php';
    require_once __DIR__.'/../../../common/admin/global.php';
    if (isset($_POST['save'])) {
        $file = __DIR__.'/../../../config.php';
        $message = "<?php

    /*
     * Saturn Configuration File
     * Copyright (c) 2021 - Saturn Authors
     * saturncms.net
     *
     * You should not edit this file directly as it can cause errors to occur.
     * Please visit the Admin Panel's Website Settings page to change this file from there.
     *
     * For help visit docs.saturncms.net
     */

    /* General */
    const CONFIG_INSTALL_URL = '".CONFIG_INSTALL_URL."';
    const CONFIG_ACTIVATION_KEY = '".$_POST['activation_key']."';
    const CONFIG_SITE_NAME = '".htmlspecialchars($_POST['site_name'], ENT_QUOTES)."';
    const CONFIG_SITE_DESCRIPTION = '".htmlspecialchars($_POST['site_description'], ENT_QUOTES)."';
    const CONFIG_SITE_KEYWORDS = '".htmlspecialchars($_POST['site_keywords'], ENT_QUOTES)."';
    const CONFIG_SITE_CHARSET = '".htmlspecialchars($_POST['site_charset'], ENT_QUOTES)."';
    const CONFIG_SITE_TIMEZONE = '".$_POST['site_timezone']."';
    const CONFIG_LANGUAGE = '".$_POST['site_language']."';
    const CONFIG_SEND_DATA = '".$_POST['send_data']."';
    /* Users and Accounts */
    const CONFIG_REGISTRATION_ENABLED = ".$_POST['registration_enabled'].";
    /* Database */
    const DATABASE_HOST = '".$_POST['database_host']."';
    const DATABASE_NAME = '".$_POST['database_name']."';
    const DATABASE_USERNAME = '".$_POST['database_username']."';
    const DATABASE_PASSWORD = '".$_POST['database_password']."';
    const DATABASE_PORT = '".$_POST['database_port']."';
    const DATABASE_PREFIX = '".$_POST['database_prefix']."';
    /* Email */
    const CONFIG_EMAIL_ADMIN = '".$_POST['email_admin']."';
    const CONFIG_EMAIL_FUNCTION = '".$_POST['email_function']."';
    const CONFIG_EMAIL_SENDFROM = '".$_POST['email_sendfrom']."';
    /* Editing */
    const CONFIG_PAGE_APPROVALS = ".$_POST['page_approvals'].';
    const CONFIG_ARTICLE_APPROVALS = '.$_POST['article_approvals'].";
    const CONFIG_MAX_TITLE_CHARS = '".$_POST['max_title_chars']."';
    const CONFIG_MAX_PAGE_CHARS = '".$_POST['max_page_chars']."';
    const CONFIG_MAX_ARTICLE_CHARS = '".$_POST['max_article_chars']."';
    const CONFIG_MAX_REFERENCES_CHARS = '".$_POST['max_references_chars']."';
    /* Notifications */
    const CONFIG_NOTIFICATIONS_LIMIT = '".$_POST['notifications_limit']."';
    const CONFIG_ALLOW_SATURN_NOTIFICATIONS = ".$_POST['saturn_notifications'].';
    const CONFIG_ALLOW_EMAIL_NOTIFICATIONS = '.$_POST['email_notifications'].';
    /* Welcome Screen */
    const CONFIG_WELCOME_SCREEN = '.$_POST['welcome_screen'].';
    const CONFIG_WELCOME_SCREEN_SHOW_TERMS = '.$_POST['welcome_screen_show_terms'].';
    /* Security */
    const SECURITY_ACTIVE = '.$_POST['security_active'].";
    const SECURITY_MODE = '".$_POST['security_mode']."';
    const SECURITY_USE_HTTPS = ".$_POST['security_use_https'].';
    const SECURITY_USE_GSS = '.$_POST['security_use_gss'].";
    const SECURITY_DEFAULT_HASH = '".$_POST['security_default_hash']."';
    const SECURITY_CHECKSUM_HASH = '".$_POST['security_checksum_hash']."';
    const LOGGING_ACTIVE = ".$_POST['logging'].';
    const LOGGING_AUTOLOG = '.$_POST['logging_autolog'].';
    /* Developer Tools */
    const CONFIG_DEBUG = '.$_POST['debug'].";
    /* Updating */
    const CONFIG_UPDATE_CHECK = ".$_POST['update_check'].";
    const CONFIG_UPDATE_AUTO = ".$_POST['update_auto'].";
    /* Permissions */
    const PERMISSION_CREATE_CATEGORY = '".PERMISSION_CREATE_CATEGORY."';
    const PERMISSION_CREATE_PAGE = '".PERMISSION_CREATE_PAGE."';
    const PERMISSION_EDIT_PAGE_SETTINGS = '".PERMISSION_EDIT_PAGE_SETTINGS."';";

        if (file_put_contents($file, $message, LOCK_EX) && ccv_reset()) {
            log_file('SATURN][SECURITY', get_user_fullname($_SESSION['id']).' '.__('Admin:Settings_Saved_Log'));
            internal_redirect('/panel/admin/settings?successMsg='.__('Admin:Settings_Saved'));
        } else {
            internal_redirect('/panel/admin/settings?errorMsg=Unable to save website settings, an error occurred.');
        }
        exit;
    }
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../common/panel/vendors.php'; ?>

        <title><?php echo __('Admin:Settings_Web'); ?> - <?php echo CONFIG_SITE_NAME.' '.__('Admin:Panel'); ?></title>
        <?php require __DIR__.'/../../../common/panel/theme.php'; ?>
    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <form class="w-full" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="mb-8 grid grid-cols-2">
                    <h1 class="text-gray-900 text-3xl"><?php echo __('Admin:Settings_Web'); ?></h1>
                    <input type="submit" name="save" value="<?php echo __('General:Save'); ?>" class="hover:shadow-lg cursor-pointer group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
                </div>
            <?php
                if (isset($_GET['errorMsg'])) {
                    echo alert('ERROR', $_GET['errorMsg']);
                    log_error('ERROR', checkInput('DEFAULT', $_GET['$errorMsg']));
                    unset($_GET['errorMsg']);
                }
                if (isset($_GET['successMsg'])) {
                    echo alert('SUCCESS', $_GET['successMsg']);
                    unset($_GET['successMsg']);
                }
            ?>
                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_General'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="site_name"><?php echo __('Admin:Settings_Site_Name'); ?></label>
                        <input id="site_name" name="site_name" type="text" value="<?php echo CONFIG_SITE_NAME; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_description"><?php echo __('Admin:Settings_Site_Description'); ?></label>
                        <input id="site_description" name="site_description" type="text" value="<?php echo CONFIG_SITE_DESCRIPTION; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_keywords"><?php echo __('Admin:Settings_Site_Keywords'); ?></label>
                        <input id="site_keywords" name="site_keywords" type="text" value="<?php echo CONFIG_SITE_KEYWORDS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_charset"><?php echo __('Admin:Settings_Site_Charset'); ?></label>
                        <select id="site_charset" name="site_charset" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option disabled>UTF</option>
                            <option value="utf-8"<?php if (CONFIG_SITE_CHARSET == 'utf-8') {
                echo ' selected';
            } ?>>UTF-8 (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="utf-16"<?php if (CONFIG_SITE_CHARSET == 'utf-16') {
                echo ' selected';
            } ?>>UTF-16</option>
                            <option value="utf-32"<?php if (CONFIG_SITE_CHARSET == 'utf-32') {
                echo ' selected';
            } ?>>UTF-32</option>
                            <option disabled>Others</option>
                            <option value="ascii"<?php if (CONFIG_SITE_CHARSET == 'ascii') {
                echo ' selected';
            } ?>>US ASCII</option>
                            <option value="unicode"<?php if (CONFIG_SITE_CHARSET == 'unicode') {
                echo ' selected';
            } ?>>Unicode (ucs2)</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_timezone"><?php echo __('Admin:Settings_Site_Timezone'); ?></label>
                        <select id="site_timezone" name="site_timezone" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <?php
                                $tzList = DateTimeZone::listIdentifiers();
                                foreach ($tzList as $value) {
                                    ?>
                            <option<?php if (CONFIG_SITE_TIMEZONE == $value) {
                                        echo ' selected';
                                    } ?>><?php echo $value; ?></option>
                            <?php
                                } ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="activation_key"><?php echo __('Admin:Settings_ActivationKey'); ?></label>
                        <input id="activation_key" name="activation_key" type="text" value="<?php echo CONFIG_ACTIVATION_KEY; ?>" class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>
                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Panel:Panel'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="site_language"><?php echo __('Admin:Settings_Panel_Language'); ?></label>
                        <select id="site_language" name="site_language" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option<?php if (CONFIG_LANGUAGE == 'bn') {
                                    echo ' selected';
                                } ?> value="bn">[BN] Bengali</option>
                            <option<?php if (CONFIG_LANGUAGE == 'de') {
                                    echo ' selected';
                                } ?> value="de">[DE] German</option>
                            <option<?php if (CONFIG_LANGUAGE == 'en-gb') {
                                    echo ' selected';
                                } ?> value="en-gb">[EN-GB] English (United Kingdom)</option>
                            <option<?php if (CONFIG_LANGUAGE == 'en-us') {
                                    echo ' selected';
                                } ?> value="en-us">[EN-US] English (United States)</option>
                            <option<?php if (CONFIG_LANGUAGE == 'es') {
                                    echo ' selected';
                                } ?> value="es">[ES] Spanish</option>
                            <option<?php if (CONFIG_LANGUAGE == 'fr') {
                                    echo ' selected';
                                } ?> value="fr">[FR] French</option>
                            <option<?php if (CONFIG_LANGUAGE == 'hi') {
                                    echo ' selected';
                                } ?> value="hi">[HI] Hindi</option>
                            <option<?php if (CONFIG_LANGUAGE == 'id') {
                                    echo ' selected';
                                } ?> value="id">[ID] Indonesian</option>
                            <option<?php if (CONFIG_LANGUAGE == 'ko') {
                                    echo ' selected';
                                } ?> value="ko">[KO] Korean</option>
                            <option<?php if (CONFIG_LANGUAGE == 'pl') {
                                    echo ' selected';
                                } ?> value="pl">[PL] Polish</option>
                            <option<?php if (CONFIG_LANGUAGE == 'pt') {
                                    echo ' selected';
                                } ?> value="pt">[PT] Portuguese</option>
                            <option<?php if (CONFIG_LANGUAGE == 'ru') {
                                    echo ' selected';
                                } ?> value="ru">[RU] Russian</option>
                            <option<?php if (CONFIG_LANGUAGE == 'zh-hans') {
                                    echo ' selected';
                                } ?> value="zh-hans">[ZH-HANS] Chinese (Simplified)</option>
                            <option<?php if (CONFIG_LANGUAGE == 'zh-hant') {
                                    echo ' selected';
                                } ?> value="zh-hant">[ZH-HANT] Chinese (Traditional)</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="send_data"><?php echo __('Admin:Settings_Panel_Telemetry'); ?></label>
                        <select id="send_data" name="send_data" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option<?php if (CONFIG_SEND_DATA == true) {
                                    echo ' selected';
                                } ?>><?php echo __('General:True'); ?></option>
                            <option<?php if (CONFIG_SEND_DATA == false) {
                                    echo ' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_Users'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="registration_enabled"><?php echo __('Admin:Settings_Users_RegistrationEnabled'); ?></label>
                        <select id="registration_enabled" name="registration_enabled" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_REGISTRATION_ENABLED) {
                                    echo ' selected';
                                } ?>><?php echo __('General:True'); ?></option>
                            <option value="false"<?php if (!CONFIG_REGISTRATION_ENABLED) {
                                    echo ' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_Updating'); ?></h2>

                    <div class="grid grid-cols-2">
                        <label for="update_check"><?php echo __('Admin:Settings_Updating_Check'); ?></label>
                        <select id="update_check" name="update_check" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option<?php if (CONFIG_UPDATE_CHECK == true) {
                                echo ' selected';
                            } ?>><?php echo __('General:True'); ?></option>
                            <option<?php if (CONFIG_UPDATE_CHECK == false) {
                                echo ' selected';
                            } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="update_auto"><?php echo __('Admin:Settings_Updating_Auto'); ?></label>
                        <select id="update_auto" name="update_auto" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option<?php if (CONFIG_UPDATE_AUTO == true) {
                                echo ' selected';
                            } ?>><?php echo __('General:True'); ?></option>
                            <option<?php if (CONFIG_UPDATE_AUTO == false) {
                                echo ' selected';
                            } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_Database'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="database_host"><?php echo __('Admin:Settings_Database_Host'); ?></label>
                        <input id="database_host" name="database_host" type="text" value="<?php echo DATABASE_HOST; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_name"><?php echo __('Admin:Settings_Database_Name'); ?></label>
                        <input id="database_name" name="database_name" type="text" value="<?php echo DATABASE_NAME; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_username"><?php echo __('Admin:Settings_Database_User'); ?></label>
                        <input id="database_username" name="database_username" type="text" value="<?php echo DATABASE_USERNAME; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_password"><?php echo __('Admin:Settings_Database_Password'); ?></label>
                        <input id="database_password" name="database_password" type="password" value="<?php echo DATABASE_PASSWORD; ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_port"><?php echo __('Admin:Settings_Database_Port'); ?></label>
                        <input id="database_port" name="database_port" type="text" value="<?php echo DATABASE_PORT; ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_prefix"><?php echo __('Admin:Settings_Database_Prefix'); ?></label>
                        <input id="database_prefix" name="database_prefix" type="text" value="<?php echo DATABASE_PREFIX; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_Email'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="email_admin"><?php echo __('Admin:Settings_Email_Admin'); ?></label>
                        <input id="email_admin" name="email_admin" type="text" value="<?php echo CONFIG_EMAIL_ADMIN; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_function"><?php echo __('Admin:Settings_Email_Function'); ?></label>
                        <select id="email_function" name="email_function" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="phpmail" selected>phpmail</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_sendfrom"><?php echo __('Admin:Settings_Email_Sendfrom'); ?></label>
                        <input id="email_sendfrom" name="email_sendfrom" type="text" value="<?php echo CONFIG_EMAIL_SENDFROM; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_Notifications'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="notifications_limit"><?php echo __('Admin:Settings_Notifications_Limit'); ?></label>
                        <input id="notifications_limit" name="notifications_limit" type="number" value="<?php echo CONFIG_NOTIFICATIONS_LIMIT; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="saturn_notifications"><?php echo __('Admin:Settings_Notifications_Saturn'); ?></label>
                        <select id="saturn_notifications" name="saturn_notifications" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_ALLOW_SATURN_NOTIFICATIONS) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?> (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="false"<?php if (!CONFIG_ALLOW_SATURN_NOTIFICATIONS) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_notifications"><?php echo __('Admin:Settings_Notifications_Email'); ?></label>
                        <select id="email_notifications" name="email_notifications" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_ALLOW_EMAIL_NOTIFICATIONS) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?> (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="false"<?php if (!CONFIG_ALLOW_EMAIL_NOTIFICATIONS) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_Welcome'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="welcome_screen"><?php echo __('Admin:Settings_Welcome_Show'); ?></label>
                        <select id="welcome_screen" name="welcome_screen" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_WELCOME_SCREEN) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?> (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="false"<?php if (!CONFIG_WELCOME_SCREEN) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="welcome_screen_show_terms"><?php echo __('Admin:Settings_Welcome_Terms'); ?></label>
                        <select id="welcome_screen_show_terms" name="welcome_screen_show_terms" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_WELCOME_SCREEN_SHOW_TERMS) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?> (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="false"<?php if (!CONFIG_WELCOME_SCREEN_SHOW_TERMS) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_PagesArticles'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="page_approvals"><?php echo __('Admin:Settings_PagesArticles_PageApprovals'); ?></label>
                        <select id="page_approvals" name="page_approvals" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_PAGE_APPROVALS) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?></option>
                            <option value="false"<?php if (!CONFIG_PAGE_APPROVALS) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="article_approvals"><?php echo __('Admin:Settings_PagesArticles_ArticleApprovals'); ?></label>
                        <select id="article_approvals" name="article_approvals" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_ARTICLE_APPROVALS) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?></option>
                            <option value="false"<?php if (!CONFIG_ARTICLE_APPROVALS) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_title_chars"><?php echo __('Admin:Settings_PagesArticles_MaxTitle'); ?></label>
                        <input id="max_title_chars" name="max_title_chars" type="number" value="<?php echo CONFIG_MAX_TITLE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_page_chars"><?php echo __('Admin:Settings_PagesArticles_MaxPageContent'); ?></label>
                        <input id="max_page_chars" name="max_page_chars" type="number" value="<?php echo CONFIG_MAX_PAGE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_article_chars"><?php echo __('Admin:Settings_PagesArticles_MaxArticleContent'); ?></label>
                        <input id="max_article_chars" name="max_article_chars" type="number" value="<?php echo CONFIG_MAX_ARTICLE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_references_chars"><?php echo __('Admin:Settings_PagesArticles_MaxReferences'); ?></label>
                        <input id="max_references_chars" name="max_references_chars" type="number" value="<?php echo CONFIG_MAX_REFERENCES_CHARS; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_Security'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="security_active"><?php echo __('Admin:Settings_Security_Active'); ?></label>
                        <select id="security_active" name="security_active" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (SECURITY_ACTIVE) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?> (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="false"<?php if (!SECURITY_ACTIVE) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_mode"><?php echo __('Admin:Settings_Security_Mode'); ?></label>
                        <select id="security_mode" name="security_mode" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="clean"<?php if (SECURITY_MODE == 'clean') {
                                    echo' selected';
                                } ?>><?php echo __('Security:Clean'); ?> (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="halt"<?php if (SECURITY_MODE == 'halt') {
                                    echo' selected';
                                } ?>><?php echo __('Security:Halt'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_use_https"><?php echo __('Admin:Settings_Security_HTTPS'); ?></label>
                        <select id="security_use_https" name="security_use_https" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (SECURITY_USE_HTTPS) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?> (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="false"<?php if (!SECURITY_USE_HTTPS) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_use_gss"><?php echo __('Admin:Settings_Security_GSS'); ?></label>
                        <select id="security_use_gss" name="security_use_gss" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (SECURITY_USE_GSS) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?> (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="false"<?php if (!SECURITY_USE_GSS) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_default_hash"><?php echo __('Admin:Settings_Security_Hash_Default'); ?></label>
                        <select id="security_default_hash" name="security_default_hash" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="sha3-512"<?php if (SECURITY_DEFAULT_HASH == 'sha3-512') {
                                    echo' selected';
                                } ?>>sha3-512 (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="sha3-384"<?php if (SECURITY_DEFAULT_HASH == 'sha3-384') {
                                    echo' selected';
                                } ?>>sha3-384</option>
                            <option value="sha3-256"<?php if (SECURITY_DEFAULT_HASH == 'sha3-256') {
                                    echo' selected';
                                } ?>>sha3-256</option>
                            <option value="sha3-224"<?php if (SECURITY_DEFAULT_HASH == 'sha3-224') {
                                    echo' selected';
                                } ?>>sha3-224</option>
                            <option value="sha512"<?php if (SECURITY_DEFAULT_HASH == 'sha512') {
                                    echo' selected';
                                } ?>>sha512</option>
                            <option value="sha512/224"<?php if (SECURITY_DEFAULT_HASH == 'sha512/224') {
                                    echo' selected';
                                } ?>>sha512/224</option>
                            <option value="sha512/256"<?php if (SECURITY_DEFAULT_HASH == 'sha512/256') {
                                    echo' selected';
                                } ?>>sha512/256</option>
                            <option value="sha256"<?php if (SECURITY_DEFAULT_HASH == 'sha256') {
                                    echo' selected';
                                } ?>>sha256</option>
                            <option value="haval256,5"<?php if (SECURITY_DEFAULT_HASH == 'haval256,5') {
                                    echo' selected';
                                } ?>>haval256,5</option>
                            <option value="haval256,4"<?php if (SECURITY_DEFAULT_HASH == 'haval256,4') {
                                    echo' selected';
                                } ?>>haval256,4</option>
                            <option value="haval256,3"<?php if (SECURITY_DEFAULT_HASH == 'haval256,3') {
                                    echo' selected';
                                } ?>>haval256,3</option>
                            <option value="whirlpool"<?php if (SECURITY_DEFAULT_HASH == 'whirlpool') {
                                    echo' selected';
                                } ?>>whirlpool</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_checksum_hash"><?php echo __('Admin:Settings_Security_Hash_Checksum'); ?></label>
                        <select id="security_checksum_hash" name="security_checksum_hash" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="sha3-512"<?php if (SECURITY_CHECKSUM_HASH == 'sha3-512') {
                                    echo' selected';
                                } ?>>sha3-512</option>
                            <option value="sha3-384"<?php if (SECURITY_CHECKSUM_HASH == 'sha3-384') {
                                    echo' selected';
                                } ?>>sha3-384</option>
                            <option value="sha3-256"<?php if (SECURITY_CHECKSUM_HASH == 'sha3-256') {
                                    echo' selected';
                                } ?>>sha3-256</option>
                            <option value="sha3-224"<?php if (SECURITY_CHECKSUM_HASH == 'sha3-224') {
                                    echo' selected';
                                } ?>>sha3-224</option>
                            <option value="sha512"<?php if (SECURITY_CHECKSUM_HASH == 'sha512') {
                                    echo' selected';
                                } ?>>sha512 (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="sha512/224"<?php if (SECURITY_CHECKSUM_HASH == 'sha512/224') {
                                    echo' selected';
                                } ?>>sha512/224</option>
                            <option value="sha512/256"<?php if (SECURITY_CHECKSUM_HASH == 'sha512/256') {
                                    echo' selected';
                                } ?>>sha512/256</option>
                            <option value="sha256"<?php if (SECURITY_CHECKSUM_HASH == 'sha256') {
                                    echo' selected';
                                } ?>>sha256</option>
                            <option value="haval256,5"<?php if (SECURITY_CHECKSUM_HASH == 'haval256,5') {
                                    echo' selected';
                                } ?>>haval256,5</option>
                            <option value="haval256,4"<?php if (SECURITY_CHECKSUM_HASH == 'haval256,4') {
                                    echo' selected';
                                } ?>>haval256,4</option>
                            <option value="haval256,3"<?php if (SECURITY_CHECKSUM_HASH == 'haval256,3') {
                                    echo' selected';
                                } ?>>haval256,3</option>
                            <option value="whirlpool"<?php if (SECURITY_CHECKSUM_HASH == 'whirlpool') {
                                    echo' selected';
                                } ?>>whirlpool</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="logging"><?php echo __('Admin:Settings_Security_Logging'); ?></label>
                        <select id="logging" name="logging" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (LOGGING_ACTIVE) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?> (<?php echo __('General:Recommended'); ?>)</option>
                            <option value="false"<?php if (!LOGGING_ACTIVE) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="logging_autolog"><?php echo __('Admin:Settings_Security_AutoLog'); ?></label>
                        <select id="logging_autolog" name="logging_autolog" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (LOGGING_AUTOLOG) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?></option>
                            <option value="false"<?php if (!LOGGING_AUTOLOG) {
                                    echo' selected';
                                } ?>>False (<?php echo __('General:Recommended'); ?>)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1"><?php echo __('Admin:Settings_Developer'); ?></h2>
                    <div class="grid grid-cols-2">
                        <label for="debug"><?php echo __('Admin:Settings_Developer_Debug'); ?></label>
                        <select id="debug" name="debug" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_DEBUG) {
                                    echo' selected';
                                } ?>><?php echo __('General:True'); ?></option>
                            <option value="false"<?php if (!CONFIG_DEBUG) {
                                    echo' selected';
                                } ?>><?php echo __('General:False'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-2">
                    <div></div>
                    <input type="submit" name="save" value="<?php echo __('General:Save'); ?>" class="hover:shadow-lg cursor-pointer group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
                </div>
            </form>
        </div>
    </body>
</html>