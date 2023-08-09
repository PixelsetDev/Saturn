<?php

use Saturn\SecurityManager\CSRF;

$CSRF = new CSRF();

?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
<head>
    <title><?= WEBSITE_NAME; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex">
    <meta name="charset" content="<?= WEBSITE_CHARSET; ?>">

    <link rel="stylesheet" type="text/css" href="<?= SATURN_ROOT; ?>/Assets/CSS/Saturn.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="body">

<main class="main">
    <img src="<?= SATURN_ROOT; ?>/Storage/Theme/Logo.webp" class="w-1/4 mx-auto" alt="Logo">

    <div class="pb-8">
        <form action="<?= SATURN_ROOT; ?>/API/Join" method="POST" class="flex">
            <div class="flex-grow"></div>
            <div class="bg-neutral-100 dark:bg-neutral-900 p-4 mt-6">
                <h1 class="text-header-nopt text-center">
                    <?= __CP('Join'); ?>
                </h1>

                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert-warning">
                        <div class="alert-warning-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-warning-text">
                            <?php
                                if ($_GET['error'] == 'exists') { echo __CP('Account_Already_Exists'); }
                                if ($_GET['error'] == 'notfound') { echo __CP('Account_Not_Found'); }
                                else { echo __CP('Unknown_Error'); }
                            ?>
                        </div>
                    </div>
                    <br>
                <?php } ?>

                <?php $CSRF->Set(); ?>
                <label for="email" class="hidden"><?= __CP('Email'); ?></label>
                <input type="text" id="email" name="email" class="input w-full mb-2" required placeholder="<?= __CP('Email'); ?>" maxlength="128"><br>
                <label for="username" class="hidden"><?= __CP('Username'); ?></label>
                <input type="text" id="username" name="username" class="input w-full mb-2" required placeholder="<?= __CP('Username'); ?>" maxlength="64"><br>
                <label for="password" class="hidden"><?= __CP('Password'); ?></label>
                <input type="password" id="password" name="password" class="input w-full mb-4" required placeholder="<?= __CP('Password'); ?>"><br>
                <button type="submit" class="input-button w-full mb-1"><?= __CP('Join'); ?></button>
            </div>
            <div class="flex-grow"></div>
        </form>
    </div>
</main>
<script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
</body>
</html>