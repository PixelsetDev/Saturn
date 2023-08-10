<?php
use Saturn\HookManager\Actions;
require_once __DIR__ . '/Include/Security.php';
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
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.DashboardContentStart'); ?>
            <div class="grid-block">
                <div class="grid-item grid-padding">
                    <span id="PageCount">...</span> Pages
                </div>
            </div>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.DashboardContentEnd'); ?>
        </main>

        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Statistics.js"></script>
    </body>
</html>