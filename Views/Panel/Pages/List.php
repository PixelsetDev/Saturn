<?php
use Saturn\ClientKit;
use Saturn\ClientKit\Translate;

new ClientKit();
$TL = new Translate();
?><!DOCTYPE html>
<html lang="<?= PANEL_LANGUAGE; ?>" class="min-h-full">
    <head>
        <?php require_once __DIR__.'/../Vendors.inc'; ?>

        <title><?= $TL->TL('SignIn'); ?> - <?= WEBSITE_NAME; ?></title>
        <?php global $Plugins; $Plugins->ExecuteHook('PANEL_HEAD_END'); ?>

    </head>
    <body class="dark:bg-black dark:text-white w-full h-full">
        <?php require_once __DIR__ . '/../Header.inc'; ?>

        <div class="flex md:flex-row flex-col w-full h-full">
            <?php require_once __DIR__ . '/../Sidebar.inc'; ?>

            <div class="h-full w-full py-8 px-10">
                <h1 class="text-3xl font-bold mb-8"><?= $TL->TL('Pages'); ?></h1>
            </div>
        </div>
    </body>
</html>