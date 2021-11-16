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
    const CONFIG_SITE_NAME = '".$_POST['site_name']."';
    const CONFIG_SITE_DESCRIPTION = '".$_POST['site_description']."';
    const CONFIG_SITE_KEYWORDS = '".$_POST['site_keywords']."';
    const CONFIG_SITE_CHARSET = '".$_POST['site_charset']."';
    const CONFIG_SITE_TIMEZONE = '".$_POST['site_timezone']."';
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
    /* Permissions */
    const PERMISSION_CREATE_CATEGORY = '".PERMISSION_CREATE_CATEGORY."';
    const PERMISSION_CREATE_PAGE = '".PERMISSION_CREATE_PAGE."';
    const PERMISSION_EDIT_PAGE_SETTINGS = '".PERMISSION_EDIT_PAGE_SETTINGS."';";

        if (file_put_contents($file, $message, LOCK_EX) && ccv_reset()) {
            log_file('SATURN][SECURITY', get_user_fullname($_SESSION['id']).' updated Website Settings.');
            internal_redirect('/panel/admin/settings?successMsg=Website settings saved successfully. You may need to refresh the page to see changes. If an error message appears, refresh the page.');
            exit;
        } else {
            internal_redirect('/panel/admin/settings?errorMsg=Unable to save website settings, an error occurred.');
            exit;
        }
    }
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../common/panel/vendors.php'; ?>

        <title>Settings - <?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__.'/../../../common/panel/theme.php'; ?>
    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <form class="w-full" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="mb-8 grid grid-cols-2">
                    <h1 class="text-gray-900 text-3xl">Settings</h1>
                    <input type="submit" name="save" value="Save" class="hover:shadow-lg cursor-pointer group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
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
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">General</h2>
                    <div class="grid grid-cols-2">
                        <label for="site_name">Site Name</label>
                        <input id="site_name" name="site_name" type="text" value="<?php echo CONFIG_SITE_NAME; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_description">Site Description</label>
                        <input id="site_description" name="site_description" type="text" value="<?php echo CONFIG_SITE_DESCRIPTION; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_keywords">Site Keywords</label>
                        <input id="site_keywords" name="site_keywords" type="text" value="<?php echo CONFIG_SITE_KEYWORDS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_charset">Site Charset</label>
                        <select id="site_charset" name="site_charset" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option disabled>UTF</option>
                            <option value="utf-8"<?php if (CONFIG_SITE_CHARSET == 'utf-8') {
                echo ' selected';
            } ?>>UTF-8</option>
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
                        <label for="site_timezone">Site Timezone</label>
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
                        <label for="activation_key">Activation Key</label>
                        <input id="activation_key" name="activation_key" type="text" value="<?php echo CONFIG_ACTIVATION_KEY; ?>" class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Users and Accounts</h2>
                    <div class="grid grid-cols-2">
                        <label for="registration_enabled">Registration Enabled</label>
                        <select id="registration_enabled" name="registration_enabled" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_REGISTRATION_ENABLED) {
                                    echo ' selected';
                                } ?>>True</option>
                            <option value="false"<?php if (!CONFIG_REGISTRATION_ENABLED) {
                                    echo ' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Database</h2>
                    <div class="grid grid-cols-2">
                        <label for="database_host">Database Host</label>
                        <input id="database_host" name="database_host" type="text" value="<?php echo DATABASE_HOST; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_name">Database Username</label>
                        <input id="database_name" name="database_name" type="text" value="<?php echo DATABASE_NAME; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_username">Database Username</label>
                        <input id="database_username" name="database_username" type="text" value="<?php echo DATABASE_USERNAME; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_password">Database Password</label>
                        <input id="database_password" name="database_password" type="password" value="<?php echo DATABASE_PASSWORD; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_port">Database Port</label>
                        <input id="database_port" name="database_port" type="text" value="<?php echo DATABASE_PORT; ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_prefix">Database Prefix</label>
                        <input id="database_prefix" name="database_prefix" type="text" value="<?php echo DATABASE_PREFIX; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Email</h2>
                    <div class="grid grid-cols-2">
                        <label for="email_admin">Administrator's Email</label>
                        <input id="email_admin" name="email_admin" type="text" value="<?php echo CONFIG_EMAIL_ADMIN; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_function">Email Function</label>
                        <select id="email_function" name="email_function" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="phpmail" selected>phpmail</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_sendfrom">Email Sendfrom</label>
                        <input id="email_sendfrom" name="email_sendfrom" type="text" value="<?php echo CONFIG_EMAIL_SENDFROM; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Notifications</h2>
                    <div class="grid grid-cols-2">
                        <label for="notifications_limit">Notifications Limit</label>
                        <input id="notifications_limit" name="notifications_limit" type="number" value="<?php echo CONFIG_NOTIFICATIONS_LIMIT; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="saturn_notifications">Allow Saturn Notifications</label>
                        <select id="saturn_notifications" name="saturn_notifications" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_ALLOW_SATURN_NOTIFICATIONS) {
                                    echo' selected';
                                } ?>>True (Recommended)</option>
                            <option value="false"<?php if (!CONFIG_ALLOW_SATURN_NOTIFICATIONS) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_notifications">Allow Email Notifications</label>
                        <select id="email_notifications" name="email_notifications" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_ALLOW_EMAIL_NOTIFICATIONS) {
                                    echo' selected';
                                } ?>>True (Recommended)</option>
                            <option value="false"<?php if (!CONFIG_ALLOW_EMAIL_NOTIFICATIONS) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Welcome Screen</h2>
                    <div class="grid grid-cols-2">
                        <label for="welcome_screen">Show Welcome Screen</label>
                        <select id="welcome_screen" name="welcome_screen" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_WELCOME_SCREEN) {
                                    echo' selected';
                                } ?>>True (Recommended)</option>
                            <option value="false"<?php if (!CONFIG_WELCOME_SCREEN) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="welcome_screen_show_terms">Show Website Terms on Welcome Screen</label>
                        <select id="welcome_screen_show_terms" name="welcome_screen_show_terms" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_WELCOME_SCREEN_SHOW_TERMS) {
                                    echo' selected';
                                } ?>>True (Recommended)</option>
                            <option value="false"<?php if (!CONFIG_WELCOME_SCREEN_SHOW_TERMS) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Pages and Articles</h2>
                    <div class="grid grid-cols-2">
                        <label for="page_approvals">Page Approvals</label>
                        <select id="page_approvals" name="page_approvals" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_PAGE_APPROVALS) {
                                    echo' selected';
                                } ?>>True</option>
                            <option value="false"<?php if (!CONFIG_PAGE_APPROVALS) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="article_approvals">Article Approvals</label>
                        <select id="article_approvals" name="article_approvals" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_ARTICLE_APPROVALS) {
                                    echo' selected';
                                } ?>>True</option>
                            <option value="false"<?php if (!CONFIG_ARTICLE_APPROVALS) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_title_chars">Maximum Title Length</label>
                        <input id="max_title_chars" name="max_title_chars" type="number" value="<?php echo CONFIG_MAX_TITLE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_page_chars">Maximum Page Content Length</label>
                        <input id="max_page_chars" name="max_page_chars" type="number" value="<?php echo CONFIG_MAX_PAGE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_article_chars">Maximum Article Content Length</label>
                        <input id="max_article_chars" name="max_article_chars" type="number" value="<?php echo CONFIG_MAX_ARTICLE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_references_chars">Maximum References Length</label>
                        <input id="max_references_chars" name="max_references_chars" type="number" value="<?php echo CONFIG_MAX_REFERENCES_CHARS; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Security System</h2>
                    <div class="grid grid-cols-2">
                        <label for="security_active">Security Active</label>
                        <select id="security_active" name="security_active" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (SECURITY_ACTIVE) {
                                    echo' selected';
                                } ?>>True (Recommended)</option>
                            <option value="false"<?php if (!SECURITY_ACTIVE) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_mode">Security Mode</label>
                        <select id="security_mode" name="security_mode" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="clean"<?php if (SECURITY_MODE == 'clean') {
                                    echo' selected';
                                } ?>>Clean (Recommended)</option>
                            <option value="halt"<?php if (SECURITY_MODE == 'halt') {
                                    echo' selected';
                                } ?>>Halt</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_use_https">Use HTTPS</label>
                        <select id="security_use_https" name="security_use_https" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (SECURITY_USE_HTTPS) {
                                    echo' selected';
                                } ?>>True (Recommended)</option>
                            <option value="false"<?php if (!SECURITY_USE_HTTPS) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_use_gss">Use Saturn Global Security System</label>
                        <select id="security_use_gss" name="security_use_gss" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (SECURITY_USE_GSS) {
                                    echo' selected';
                                } ?>>True (Recommended)</option>
                            <option value="false"<?php if (!SECURITY_USE_GSS) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_default_hash">Default Hash</label>
                        <select id="security_default_hash" name="security_default_hash" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="sha3-512"<?php if (SECURITY_DEFAULT_HASH == 'sha3-512') {
                                    echo' selected';
                                } ?>>sha3-512 (Recommended)</option>
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
                        <label for="security_checksum_hash">Checksum Hash</label>
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
                                } ?>>sha512 (Recommended)</option>
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
                        <label for="logging">Logging Active</label>
                        <select id="logging" name="logging" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (LOGGING_ACTIVE) {
                                    echo' selected';
                                } ?>>True (Recommended)</option>
                            <option value="false"<?php if (!LOGGING_ACTIVE) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="logging_autolog">AutoLog Active</label>
                        <select id="logging_autolog" name="logging_autolog" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (LOGGING_AUTOLOG) {
                                    echo' selected';
                                } ?>>True</option>
                            <option value="false"<?php if (!LOGGING_AUTOLOG) {
                                    echo' selected';
                                } ?>>False (Recommended)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Developer Tools</h2>
                    <div class="grid grid-cols-2">
                        <label for="debug">Debug Mode</label>
                        <select id="debug" name="debug" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if (CONFIG_DEBUG) {
                                    echo' selected';
                                } ?>>True</option>
                            <option value="false"<?php if (!CONFIG_DEBUG) {
                                    echo' selected';
                                } ?>>False</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-2">
                    <div></div>
                    <input type="submit" name="save" value="Save" class="hover:shadow-lg cursor-pointer group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
                </div>
            </form>
        </div>
    </body>
</html>