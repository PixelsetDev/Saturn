<?php

use Saturn\SecurityManager\CSRF;

$CSRF = new CSRF();

?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
<head>
    <title><?= WEBSITE_NAME ?></title>

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
        <form action="<?= SATURN_ROOT; ?>/API/Login" method="POST" class="flex">
            <div class="flex-grow"></div>
            <div class="bg-neutral-100 dark:bg-neutral-900 p-4 mt-6">
                <h1 class="text-header-nopt text-center">
                    <?= __CP('Login'); ?>
                </h1>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="alert-success">
                        <div class="alert-success-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-success-text">
                            <?php
                            if ($_GET['success'] == 'created') { echo __CP('Account_Created'); }
                            if ($_GET['success'] == 'logout') { echo __CP('Account_Logged_Out'); }
                            else { echo __CP('Unknown_Success'); }
                            ?>
                        </div>
                    </div>
                    <br>
                <?php } ?>

                <?php $CSRF->Set(); ?>
                <label for="username" class="hidden"><?= __CP('Username_or_Email'); ?></label>
                <input type="text" id="username" name="username" class="input w-full mb-2" required placeholder="<?= __CP('Username_or_Email'); ?>"><br>
                <label for="password" class="hidden"><?= __CP('Password'); ?></label>
                <input type="password" id="password" name="password" class="input w-full mb-4" required placeholder="<?= __CP('Password'); ?>"><br>
                <button type="submit" class="input-button w-full"><?= __CP('Login'); ?></button>

                <br>

                <div class="grid grid-cols-2 gap-2 mt-2 text-center">
                    <a href="<?= SATURN_ROOT; ?>/account/join" class="input-button"><?= __CP('Register'); ?></a>

                    <a href="<?= SATURN_ROOT; ?>/account/reset" class="input-button"><?= __CP('Forgot_Password'); ?></a>
                </div>
            </div>
            <div class="flex-grow"></div>
        </form>
    </div>
</main>
</body>
</html>