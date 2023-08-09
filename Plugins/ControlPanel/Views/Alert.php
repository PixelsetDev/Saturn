<?php
use Saturn\AccountManager\Permissions;
use ControlPanel\Checksums;

$Permissions = new Permissions($_SESSION['uuid']);

if (isset($_GET['resetconfirm'])) {
    if ($Permissions->HasPermission(['administrator','panel_settings'],'OR')) {
        require_once __DIR__ . '/../Checksums.php';
        $Checksums = new Checksums();
        $Checksums->Reset();

        header('Location: /panel');
        exit;
    }
}
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= __CP('Alert'); ?> - <?= WEBSITE_NAME ?> <?= __CP('ControlPanel'); ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="robots" content="noindex">
        <meta name="charset" content="<?= WEBSITE_CHARSET; ?>">

        <link rel="stylesheet" type="text/css" href="<?= SATURN_ROOT; ?>/Assets/CSS/Saturn.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="body">
        <nav class="navigation">
            <div class="flex-grow self-center">
                <a href="<?= SATURN_ROOT; ?>">
                    <img src="<?= SATURN_ROOT; ?>/Storage/Theme/Logo.webp" alt="Logo" width="125px">
                </a>
            </div>
            <a href="<?= SATURN_ROOT; ?>/account" class="navigation-item"><?= __CP('Account'); ?></a>
        </nav>
        <main class="main">
            <h1 class="text-header-nopt"><?= __CP('SecurityAlert'); ?></h1>
            <p><?= __CP('SecurityAlert_Disabled'); ?></p><br>
            <?php if ($Permissions->HasPermission(['administrator','panel_settings'],'OR')) { ?>
                <p><?= __CP('SecurityAlert_Checksums'); ?></p><br>
                <?php if (isset($_GET['reset'])) { ?>
                    <div class="alert-warning">
                        <div class="alert-warning-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-warning-text">
                            <?= __CP('SecurityAlert_ResetConfirm'); ?>
                        </div>
                    </div><br>
                    <a href="/panel/alert?resetconfirm=true" class="input-button"><?= __CP('SecurityAlert_Reset'); ?></a>
                <?php } else { ?>
                    <a href="/panel/alert?reset=false" class="input-button"><?= __CP('SecurityAlert_Reset'); ?></a>
                <?php } ?>
            <?php } else { ?>
                <p><?= __CP('SecurityAlert_NoPermissions'); ?></p>
            <?php } ?>
        </main>

        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Statistics.js"></script>
    </body>
</html>