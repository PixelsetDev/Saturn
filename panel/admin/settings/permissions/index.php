<?php
session_start();
ob_start();
require_once __DIR__.'/../../../../common/global_private.php';
require_once __DIR__.'/../../../../common/admin/global.php';

if (isset($_POST['save'])) {
    $file = __DIR__.'/../../../../config.php';

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
    const CONFIG_ACTIVATION_KEY = '".CONFIG_ACTIVATION_KEY."';
    const CONFIG_SITE_NAME = '".CONFIG_SITE_NAME."';
    const CONFIG_SITE_DESCRIPTION = '".CONFIG_SITE_DESCRIPTION."';
    const CONFIG_SITE_KEYWORDS = '".CONFIG_SITE_KEYWORDS."';
    const CONFIG_SITE_CHARSET = '".CONFIG_SITE_CHARSET."';
    const CONFIG_SITE_TIMEZONE = '".CONFIG_SITE_TIMEZONE."';
    const CONFIG_SEND_DATA = '".CONFIG_SEND_DATA."';
    /* Users and Accounts */
    const CONFIG_REGISTRATION_ENABLED = ".CONFIG_REGISTRATION_ENABLED.";
    /* Database */
    const DATABASE_HOST = '".DATABASE_HOST."';
    const DATABASE_NAME = '".DATABASE_NAME."';
    const DATABASE_USERNAME = '".DATABASE_USERNAME."';
    const DATABASE_PASSWORD = '".DATABASE_PASSWORD."';
    const DATABASE_PORT = '".DATABASE_PORT."';
    const DATABASE_PREFIX = '".DATABASE_PREFIX."';
    /* Email */
    const CONFIG_EMAIL_ADMIN = '".CONFIG_EMAIL_ADMIN."';
    const CONFIG_EMAIL_FUNCTION = '".CONFIG_EMAIL_FUNCTION."';
    const CONFIG_EMAIL_SENDFROM = '".CONFIG_EMAIL_SENDFROM."';
    /* Editing */
    const CONFIG_PAGE_APPROVALS = ".CONFIG_PAGE_APPROVALS.';
    const CONFIG_ARTICLE_APPROVALS = '.CONFIG_ARTICLE_APPROVALS.";
    const CONFIG_MAX_TITLE_CHARS = '".CONFIG_MAX_TITLE_CHARS."';
    const CONFIG_MAX_PAGE_CHARS = '".CONFIG_MAX_PAGE_CHARS."';
    const CONFIG_MAX_ARTICLE_CHARS = '".CONFIG_MAX_ARTICLE_CHARS."';
    const CONFIG_MAX_REFERENCES_CHARS = '".CONFIG_MAX_REFERENCES_CHARS."';
    /* Notifications */
    const CONFIG_NOTIFICATIONS_LIMIT = '".CONFIG_NOTIFICATIONS_LIMIT."';
    const CONFIG_ALLOW_SATURN_NOTIFICATIONS = ".CONFIG_ALLOW_SATURN_NOTIFICATIONS.';
    const CONFIG_ALLOW_EMAIL_NOTIFICATIONS = '.CONFIG_ALLOW_EMAIL_NOTIFICATIONS.';
    /* Welcome Screen */
    const CONFIG_WELCOME_SCREEN = '.CONFIG_WELCOME_SCREEN.';
    const CONFIG_WELCOME_SCREEN_SHOW_TERMS = '.CONFIG_WELCOME_SCREEN_SHOW_TERMS.';
    /* Security */
    const SECURITY_ACTIVE = '.SECURITY_ACTIVE.";
    const SECURITY_MODE = '".SECURITY_MODE."';
    const SECURITY_USE_HTTPS = ".SECURITY_USE_HTTPS.';
    const SECURITY_USE_GSS = '.SECURITY_USE_GSS.";
    const SECURITY_DEFAULT_HASH = '".SECURITY_DEFAULT_HASH."';
    const SECURITY_CHECKSUM_HASH = '".SECURITY_CHECKSUM_HASH."';
    const LOGGING_ACTIVE = ".LOGGING_ACTIVE.';
    const LOGGING_AUTOLOG = '.LOGGING_AUTOLOG.';
    /* Developer Tools */
    const CONFIG_DEBUG = '.CONFIG_DEBUG.';
    /* Updating */
    const CONFIG_UPDATE_CHECK = '.CONFIG_UPDATE_CHECK.';
    const CONFIG_UPDATE_AUTO = '.CONFIG_UPDATE_AUTO.";
    /* Permissions */
    const PERMISSION_CREATE_CATEGORY = '".$_POST['PERMISSION_CREATE_CATEGORY']."';
    const PERMISSION_CREATE_PAGE = '".$_POST['PERMISSION_CREATE_PAGE']."';
    const PERMISSION_EDIT_PAGE_SETTINGS = '".$_POST['PERMISSION_EDIT_PAGE_SETTINGS']."';";

    if (file_put_contents($file, $message, LOCK_EX) && ccv_reset()) {
        log_file('SATURN][SECURITY', get_user_fullname($_SESSION['id']).' updated Website Settings.');
        internal_redirect('/panel/admin/settings/permissions?successMsg=Website settings saved successfully. You may need to refresh the page to see changes. If an error message appears, refresh the page.');
    } else {
        internal_redirect('/panel/admin/settings/permissions?errorMsg=Unable to save website settings, an error occurred.');
    }
    exit;
}
ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__.'/../../../../common/panel/vendors.php'; ?>

    <title>Permissions - <?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
    <?php require __DIR__.'/../../../../common/panel/theme.php'; ?>
</head>
<body class="bg-gray-200">
<?php require __DIR__.'/../../../../common/admin/navigation.php'; ?>

<div class="px-8 py-4 w-full">
    <form class="w-full" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="mb-8 grid grid-cols-2">
            <h1 class="text-gray-900 text-3xl">Permissions</h1>
            <input type="submit" name="save" value="Save" class="hover:shadow-lg cursor-pointer group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
        </div>
        <?php
        if (isset($_GET['errorMsg'])) {
            echo alert('ERROR', $_GET['errorMsg']);
            log_error('ERROR', checkInput('DEFAULT', $errorMsg));
            unset($_GET['errorMsg']);
        }
        if (isset($_GET['successMsg'])) {
            echo alert('SUCCESS', $_GET['successMsg']);
            unset($_GET['successMsg']);
        }
        ?>
        <div class="mt-4">
            <h2 class="text-gray-900 text-2xl pb-4 mb-1">Pages and Categories</h2>
            <div class="mt-4">
                <div class="grid grid-cols-2">
                    <label for="PERMISSION_CREATE_CATEGORY">Create Category</label>
                    <select id="PERMISSION_CREATE_CATEGORY" name="PERMISSION_CREATE_CATEGORY" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                        <option value="2"<?php if (PERMISSION_CREATE_CATEGORY == '2') {
            echo ' selected';
        } ?>>Not Restricted: Administrators, Edits and Writers.</option>
                        <option value="3"<?php if (PERMISSION_CREATE_CATEGORY == '3') {
            echo ' selected';
        } ?>>Restricted: Administrators and Editors Only</option>
                        <option value="4"<?php if (PERMISSION_CREATE_CATEGORY == '4') {
            echo ' selected';
        } ?>>Restricted: Administrators Only</option>
                    </select>
                </div>
                <div class="grid grid-cols-2">
                    <label for="PERMISSION_CREATE_PAGE">Create Page</label>
                    <select id="PERMISSION_CREATE_PAGE" name="PERMISSION_CREATE_PAGE" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                        <option value="2"<?php if (PERMISSION_CREATE_PAGE == '3') {
            echo ' selected';
        } ?>>Not Restricted: Administrators, Edits and Writers.</option>
                        <option value="3"<?php if (PERMISSION_CREATE_PAGE == '3') {
            echo ' selected';
        } ?>>Restricted: Administrators and Editors Only</option>
                        <option value="4"<?php if (PERMISSION_CREATE_PAGE == '4') {
            echo ' selected';
        } ?>>Restricted: Administrators Only</option>
                    </select>
                </div>
                <div class="grid grid-cols-2">
                    <label for="PERMISSION_EDIT_PAGE_SETTINGS">Edit Page Setting</label>
                    <select id="PERMISSION_EDIT_PAGE_SETTINGS" name="PERMISSION_EDIT_PAGE_SETTINGS" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                        <option value="2"<?php if (PERMISSION_EDIT_PAGE_SETTINGS == '3') {
            echo ' selected';
        } ?>>Not Restricted: Administrators, Edits and Writers.</option>
                        <option value="3"<?php if (PERMISSION_EDIT_PAGE_SETTINGS == '3') {
            echo ' selected';
        } ?>>Restricted: Administrators and Editors Only</option>
                        <option value="4"<?php if (PERMISSION_EDIT_PAGE_SETTINGS == '4') {
            echo ' selected';
        } ?>>Restricted: Administrators Only</option>
                    </select>
                </div>
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