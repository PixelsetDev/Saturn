<?php

/**
 * Saturn View Manager - No View.
 *
 * This file is used when a view is not found.
 */
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= __('No_Homepage'); ?> - <?= out(WEBSITE_NAME); ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="robots" content="noindex">
        <meta name="charset" content="<?= WEBSITE_CHARSET; ?>">

        <link rel="stylesheet" type="text/css" href="<?= out(SATURN_ROOT); ?>/Assets/CSS/Saturn.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="body">
        <nav class="navigation">
            <a href="/" class="navigation-item"><?= __('Home'); ?></a>
        </nav>

        <main class="main">
            <img src="<?= out(SATURN_ROOT); ?>/Assets/Images/Saturn-logo.webp" class="w-1/4 mx-auto" alt="Logo">

            <div class="pb-8">
                <h1 class="text-header">
                    <?= __('No_Homepage'); ?>
                </h1>

                <p class="text-body">
                    <?= __('No_Homepage_Instructions_1'); ?><a href="../../index.php"><?= __('Saturn_Control_Panel'); ?></a><?= __('No_Homepage_Instructions_2'); ?>
                </p>

                <p class="text-body text-center">
                    <a href="/panel" class="navigation-item">Login</a>
                </p>
            </div>
        </main>
    </body>
</html>
