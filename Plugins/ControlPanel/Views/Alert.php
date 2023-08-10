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
        <?php require_once __DIR__ . '/Include/Header.php'; ?>
    </head>
    <body class="body">
        <?php require_once __DIR__ . '/Include/Navigation.php'; ?>
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