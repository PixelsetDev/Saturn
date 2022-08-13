<?php
use Saturn\ClientKit\GUI;
use Saturn\ClientKit\SecureArea;
use Saturn\ClientKit\Translate;

$SecureArea = new SecureArea();
$TL = new Translate();
$GUI = new GUI();
?><!DOCTYPE html>
<html lang="<?= PANEL_LANGUAGE; ?>" class="min-h-full">
    <head>
        <?php require_once __DIR__.'/../Vendors.inc'; ?>

        <title><?= $TL->TL('SignIn'); ?> - <?= WEBSITE_NAME; ?></title>
    </head>
    <body class="bg-[url('/Assets/Images/LoginBackground<?= PANEL_IMAGE_QUALITY; ?>.webp')] dark:bg-[url('')] bg-cover bg-center bg-no-repeat dark:bg-black min-h-full">
        <div class="my-16 max-w-sm mx-auto bg-neutral-300 dark:bg-neutral-800">
            <div class="w-full py-12 relative overflow-hidden">
                <img src="/Assets/Images/SaturnIcon.png" class="absolute left-0 right-0 -top-8 h-40 p-1 mx-auto grayscale" alt="Saturn">
            </div>
            <form class="bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white w-full h-full" action="" method="POST">
                <div class="md:px-6 md:py-8 sm:px-4 sm:py-6 px-2 py-4">
                    <h1 class="text-3xl text-center font-bold mb-8"><?= $_SESSION['username']; ?></h1>
                    <p class="text-xl text-center mb-8"><?= $TL->TL('SignedIn'); ?></p>
                </div>
                <div class="md:p-6 sm:p-4 p-2 w-full bg-neutral-300 dark:bg-neutral-800 grid grid-cols-2 gap-2">
                    <a href="/" class="btn-sm">
                        <?= $TL->TL('Exit'); ?>
                    </a>
                    <a href="/account/signout" class="btn-sm">
                        <?= $TL->TL('SignOut'); ?>
                    </a>
                </div>
            </form>
        </div>
        <p class="absolute bottom-1 left-1 text-xs text-white/50">
            <?= $TL->TL('Copyright'); ?> &copy; 2021 - <?= date('Y'); ?> <?= $TL->TL('SaturnCMS'); ?>
        </p>
    </body>
</html>