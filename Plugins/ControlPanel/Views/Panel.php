<?php
use Saturn\AccountManager\Permissions;
use Saturn\HookManager\Actions;
require_once __DIR__ . '/Include/Security.php';
$Permissions = new Permissions($_SESSION['UUID']);
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= WEBSITE_NAME ?> <?= __CP('ControlPanel'); ?></title>
        <?php require_once __DIR__ . '/Include/Header.php'; ?>
    </head>
    <body class="body">
        <?php require_once __DIR__ . '/Include/Navigation.php'; ?>
        <main class="main">
            <h1 class="text-header-nopt"><?= __CP('Dashboard'); ?></h1>
            <h2 class="text-subheader"><?= __CP('Statistics'); ?></h2>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.DashboardContentStart'); ?>
            <div class="grid-block">
                <div class="grid-item grid-padding">
                    <span id="PageCount">...</span> Pages
                </div>
            </div>

            <?php if ($Permissions->HasPermission(['administrator','panel_settings'],'OR')) { ?>
            <h2 class="text-subheader"><?= __CP('Settings'); ?></h2>
            <div class="grid-block">
                <a href="<?= SATURN_ROOT; ?>/panel/plugins" class="grid-item-link grid-padding">
                    <?= __CP('Plugins'); ?>
                </a>
                <a href="<?= SATURN_ROOT; ?>/panel/users" class="grid-item-link grid-padding">
                    <?= __CP('Users'); ?>
                </a>
            </div>
            <?php } ?>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.DashboardContentEnd'); ?>
        </main>

        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Statistics.js"></script>
    </body>
</html>