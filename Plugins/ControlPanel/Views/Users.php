<?php
use Saturn\DatabaseManager\DBMS;
use Saturn\HookManager\Actions;
require_once __DIR__ . '/Include/Security.php';
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= __CP('Users'); ?> - <?= WEBSITE_NAME ?> <?= __CP('ControlPanel'); ?></title>
        <?php require_once __DIR__ . '/Include/Header.php'; ?>
    </head>
    <body class="body">
        <?php require_once __DIR__ . '/Include/Navigation.php'; ?>
        <main class="main">
            <h1 class="text-header-nopt"><?= __CP('Users'); ?></h1>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.UsersListStart'); ?>
            <div class="grid grid-cols-1 gap-2">
                <?php
                    $DBMS = new DBMS();
                    $Users = $DBMS->Select('*','user','1','all:assoc');
                    foreach ($Users as $User) {
                ?>
                <a class="grid-item-link grid-padding relative" href="<?= SATURN_ROOT; ?>/panel/users/<?= $User['uuid']; ?>">
                    <h2 class="text-3xl font-bold"><?= $User['username']; ?></h2>
                </a>
                <?php } ?>
            </div>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.UsersListEnd'); ?>
        </main>

        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
    </body>
</html>