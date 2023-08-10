<?php
use Saturn\DatabaseManager\DBMS;
use Saturn\HookManager\Actions;
require_once __DIR__ . '/Include/Security.php';
$UUID = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$DBMS = new DBMS();
$User = $DBMS->Select('*','user',"`uuid` = '".$DBMS->Escape($UUID)."'",'first:object');
$Permissions = $DBMS->Select('*','user_permissions',"`uuid` = '".$DBMS->Escape($UUID)."'",'first:object');
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= $User->username ?> - <?= WEBSITE_NAME ?> <?= __CP('ControlPanel'); ?></title>
        <?php require_once __DIR__ . '/Include/Header.php'; ?>
    </head>
    <body class="body">
        <?php require_once __DIR__ . '/Include/Navigation.php'; ?>
        <main class="main">
            <h1 class="text-header-nopt"><?= $User->username ?></h1>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.UsersPageStart'); ?>
            <div class="grid lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 grid gap-4">
                    <div class="grid-item grid-padding">

                    </div>
                </div>

                <div class="grid-item grid-padding">
                    <h2 class="text-subheader-nopt"><?= __CP('User_Permissions'); ?></h2>
                    <?php if ($Permissions->administrator) { ?>
                        <i class="fa-solid fa-check text-green-500" aria-hidden="true"></i>
                    <?php } else { ?>
                        <i class="fa-solid fa-times text-red-500" aria-hidden="true"></i>
                    <?php } ?> <?= __CP('User_Permissions_Administrator'); ?><br>

                    <?php if ($Permissions->panel_access) { ?>
                        <i class="fa-solid fa-check text-green-500" aria-hidden="true"></i>
                    <?php } else { ?>
                        <i class="fa-solid fa-times text-red-500" aria-hidden="true"></i>
                    <?php } ?> <?= __CP('User_Permissions_Panel_Access'); ?><br>

                    <?php if ($Permissions->panel_pages_edit) { ?>
                        <i class="fa-solid fa-check text-green-500" aria-hidden="true"></i>
                    <?php } else { ?>
                        <i class="fa-solid fa-times text-red-500" aria-hidden="true"></i>
                    <?php } ?> <?= __CP('User_Permissions_Panel_Pages_Edit'); ?><br>

                    <?php if ($Permissions->panel_settings) { ?>
                        <i class="fa-solid fa-check text-green-500" aria-hidden="true"></i>
                    <?php } else { ?>
                        <i class="fa-solid fa-times text-red-500" aria-hidden="true"></i>
                    <?php } ?> <?= __CP('User_Permissions_Panel_Settings'); ?><br>
                </div>
            </div>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.UsersPageEnd'); ?>
        </main>

        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
    </body>
</html>