<?php
use Saturn\ClientKit\Translate;

$TL = new Translate();
?><!DOCTYPE html>
<html lang="<?= PANEL_LANGUAGE; ?>" class="min-h-full">
    <head>
        <?php require_once __DIR__.'/../Vendors.inc'; ?>

        <title><?= $TL->TL('Reset'); ?> - <?= WEBSITE_NAME; ?></title>
    </head>
    <body class="bg-[url('/Assets/Images/LoginBackground<?= PANEL_IMAGE_QUALITY; ?>.webp')] dark:bg-[url('')] bg-cover bg-center bg-no-repeat dark:bg-black min-h-full">
        <div class="my-16 max-w-sm mx-auto bg-neutral-300 dark:bg-neutral-800">
            <div class="w-full py-12 relative overflow-hidden">
                <img src="/Assets/Images/SaturnIcon.png" class="absolute left-0 right-0 -top-8 h-40 p-1 mx-auto grayscale" alt="Saturn">
            </div>
            <form class="bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white w-full h-full" action="" method="POST">
                <div class="md:px-6 md:py-8 sm:px-4 sm:py-6 px-2 py-4">
                    <h1 class="text-3xl text-center font-bold mb-8"><?= $TL->TL('Reset'); ?></h1>
                    <input type="text" name="email" id="email" maxlength="127" required placeholder="<?= $TL->TL('Email'); ?>" class="input-full">
                </div>
                <div class="md:p-6 sm:p-4 p-2 w-full bg-neutral-300 dark:bg-neutral-800 grid gap-2">
                    <button type="submit" name="login" id="login" class="btn">
                        <i class="fas fa-lock fa-sm absolute left-4 top-1/3" aria-hidden="true"></i> <span><?= $TL->TL('Reset'); ?></span>
                    </button>
                    <a href="/account" class="btn-sm">
                        <?= $TL->TL('Back'); ?>
                    </a>
                </div>
            </form>
        </div>
        <p class="absolute bottom-1 left-1 text-xs text-white/50">
            <?= $TL->TL('Copyright'); ?> &copy; 2021 - <?= date('Y'); ?> <?= $TL->TL('SaturnCMS'); ?>
        </p>
    </body>
</html>