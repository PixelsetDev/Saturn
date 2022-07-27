<?php
use Saturn\ClientKit;
use Saturn\ClientKit\Translate;
new ClientKit();
$TL = new Translate();
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <?php require_once __DIR__ . '/../Vendors.inc'; ?>

        <title><?= $TL->TL('SignIn'); ?> - <?= $TL->TL('Saturn'); ?></title>
    </head>
    <body>
        <div class="h-screen w-screen bg-[url('/Assets/Images/LoginBackground.webp')] bg-cover bg-center bg-no-repeat blur absolute z-10">&nbsp;</div>
        <div class="absolute top-0 bottom-0 left-0 right-0 md:filter-none bg-white/50 md:mx-auto md:w-1/2 w-full mx-2 z-20 lg:my-16 md:my-8 sm:my-4 my-2 rounded-md shadow-lg">
            <form class="lg:px-8 lg:py-10 md:px-6 md:py-8 sm:px-4 sm:py-6 px-2 py-4 text-white relative w-full h-full" action="/panel" method="POST">
                <img src="/Assets/Images/SaturnIcon.png" class="w-24 h-24 bg-white shadow-xl rounded-xl p-1 mx-auto" alt="Saturn">
                <h1 class="text-3xl text-center font-bold my-8"><?= $TL->TL('SignIn_Message'); ?></h1>
                <input type="text" name="username" id="username" maxlength="127" required placeholder="<?= $TL->TL('UsernameEmail'); ?>" class="block w-full px-2 py-1 rounded-t-md bg-neutral-100 text-black appearance-none border">
                <input type="password" name="password" id="password" maxlength="255" required placeholder="<?= $TL->TL('Password'); ?>" class="block w-full px-2 py-1 rounded-b-md bg-neutral-100 text-black appearance-none mb-8 border">
                <button type="submit" name="login" id="login" class="block w-full px-3 py-2 rounded-md bg-white text-black appearance-none mb-8 shadow-lg hover:shadow-xl bg-neutral-100 hover:bg-white transition duration-200">
                    <i class="fas fa-lock" aria-hidden="true"></i> <?= $TL->TL('SignIn'); ?>
                </button>
                <div class="grid grid-cols-2 text-sm">
                    <p><?= $TL->TL('ForgotDetails'); ?></p>
                    <p class="text-right"><?= $TL->TL('CreateAccount'); ?></p>
                </div>
                <p class="absolute bottom-0 text-xs pb-2 text-white/50">
                    <?= $TL->TL('Copyright'); ?> &copy; 2021 - <?= date('Y'); ?> <?= $TL->TL('SaturnCMS'); ?>
                </p>
            </form>
        </div>

    </body>
</html>