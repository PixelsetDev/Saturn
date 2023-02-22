<?php

use Saturn\SecurityManager\CSRF;

$CSRF = new CSRF();

?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
<head>
    <title><?= __('Saturn'); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex">
    <meta name="charset" content="<?= WEBSITE_CHARSET; ?>">

    <link rel="stylesheet" type="text/css" href="<?= WEBSITE_ROOT; ?>/Assets/CSS/Saturn.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="body">

<main class="main">
    <img src="<?= WEBSITE_ROOT; ?>/Assets/Images/Saturn-logo.webp" class="w-1/4 mx-auto" alt="Logo">

    <div class="pb-8">
        <form action="<?= WEBSITE_ROOT; ?>/account" method="POST" class="flex">
            <div class="flex-grow"></div>
            <div class="bg-neutral-100 dark:bg-neutral-900 p-4 mt-6">
                <h1 class="text-header-nopt text-center">
                    <?= __('Login'); ?>
                </h1>

                <?php $CSRF->set_csrf(); ?>
                <input type="text" id="username" name="username" class="input w-full mb-2" required placeholder="<?= __('Username_or_Email'); ?>"><br>
                <input type="password" id="password" name="password" class="input w-full mb-4" required placeholder="<?= __('Password'); ?>"><br>
                <button type="submit" class="input-button w-full mb-1"><?= __('Login'); ?></button>

                <br>

                <a href="<?= WEBSITE_ROOT; ?>/account/join" class="input-button"><?= __('Register'); ?></a>

                <a href="<?= WEBSITE_ROOT; ?>/account/reset" class="input-button"><?= __('Forgot_Password'); ?></a>
            </div>
            <div class="flex-grow"></div>
        </form>
    </div>
</main>
</body>
</html>