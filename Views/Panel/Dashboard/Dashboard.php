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
    </head>
    <body class="dark:bg-black dark:text-white flex w-full h-full">
        <div class="w-1/12 h-full">
            <?php require_once __DIR__.'/../Navigation.inc'; ?>
        </div>
        <div class="w-11/12 h-full">
            <div class="container max-w-3xl mx-auto">
                <h1 class="text-3xl text-center font-bold mb-8"><?= $TL->TL('Dashboard'); ?></h1>
            </div>
        </div>
    </body>
</html>