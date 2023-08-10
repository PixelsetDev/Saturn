<?php
use Saturn\HookManager\Actions;
use Saturn\PluginManager\PluginCompatability;
use Saturn\PluginManager\ContentManager;
use Saturn\PluginManager\PluginManifest;
require_once __DIR__ . '/Include/Security.php';
$Slug = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$PM = new PluginManifest();
$Manifest = $PM->GetManifest($Slug);

global $SaturnPlugins;

if (isset($_GET['uninstall']) && $_GET['uninstall'] === 'confirmed') {
    $ContentManager = new ContentManager();
    if ($ContentManager->Delete($Manifest->Slug)) {
        header('Location: ' . SATURN_ROOT . '/panel/plugins');
    } else {
        header('Location: ' . SATURN_ROOT . '/panel/plugins/' . $Manifest->Slug . '?uninstallerror');
    }
    exit;
}
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= $Manifest->Name ?> - <?= WEBSITE_NAME ?> <?= __CP('ControlPanel'); ?></title>

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
            <div class="flex">
                <h1 class="text-header-nopt flex-grow"><?= $Manifest->Name; ?></h1>
                <div class="self-center">
                    <a href="<?= SATURN_ROOT; ?>/panel/plugins" class="btn-lg"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i> <?= __CP('Back'); ?></a>
                </div>
            </div>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.PluginPageStart'); ?>

            <?php if (!$SaturnPlugins[$Slug]['Loaded']) { ?>
            <div class="alert-warning mb-6">
                <div class="alert-warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-warning-text">
                    <strong><?= __CP('Plugin_NotLoaded_Message'); ?></strong><br>
                    <?= __CP('Plugin_NotLoaded_Reason'); ?> <?= $SaturnPlugins[$Slug]['Reason']; ?>
                </div>
            </div>
            <?php } if (isset($_GET['uninstall'])) { ?>
                <div class="alert-warning mb-6">
                    <div class="alert-warning-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert-warning-text">
                        <strong><?= __CP('Uninstall_Confirm_Message'); ?> <?= $Manifest->Name; ?></strong><br>
                        <p class="mb-2"><a href="?uninstall=confirmed" class="bg-red-500 hover:bg-red-400 text-white transition duration-200 px-2 py-1"><?= __CP('Uninstall_Confirm'); ?></a></p>
                    </div>
                </div>
            <?php } if (isset($_GET['uninstallerror'])) { ?>
                <div class="alert-warning mb-6">
                    <div class="alert-warning-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="alert-warning-text">
                        <strong><?= __CP('Uninstall_Error'); ?></strong><br>
                    </div>
                </div>
            <?php } ?>

            <div class="grid lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 grid gap-4">
                    <div class="grid-item grid-padding">
                        <h2 class="text-subheader-nopt"><?= __CP('Plugin_About'); ?></h2>
                        <p class="pb-2"><?= $Manifest->Description; ?></p>
                    </div>

                    <?php if ($Manifest->Conflicts !== []) { ?>
                    <div class="grid-item grid-padding">
                        <h2 class="text-subheader-nopt"><?= __CP('Plugin_Conflicts'); ?></h2>
                        <p><?= __CP('Plugin_Conflicts_Message'); ?></p>
                        <?php
                            $i = 0;
                            foreach ($Manifest->Conflicts as $Conflict) {
                                if ($i !== 0) { echo ', '; }
                                echo $Conflict;
                                $i++;
                            }
                        ?>
                    </div>
                    <?php } ?>

                    <div class="grid-item grid-padding">
                        <h2 class="text-subheader-nopt"><?= __CP('PowerFeatures'); ?></h2>
                        <p class="pb-2"><?= __CP('PowerFeatures_Message'); ?></p>
                        <?php if ($Manifest->Hibernate !== false) { ?>
                        <p><i class="fa-solid fa-moon" aria-hidden="true"></i> <strong><?= __CP('PowerFeatures_Hibernate'); ?></strong> <?= __CP('PowerFeatures_Hibernate_Message'); ?></p>
                        <?php } else { ?>
                        <p><?= __CP('PowerFeatures_None'); ?></p>
                        <?php } ?>
                    </div>
                </div>

                <div class="grid gap-4">
                    <div class="grid-item grid-padding">
                        <?php
                            if (sizeof($Manifest->Author) > 1) {
                                echo '<h2 class="text-subheader-nopt">' . __CP('Plugin_Authors') . '</h2>';
                            } else {
                                echo '<h2 class="text-subheader-nopt">' . __CP('Plugin_Author') . '</h2>';
                            }
                        ?>
                        <p>
                            <?php
                            $i = 0;
                            foreach ($Manifest->Author as $Author) {
                                if ($i !== 0) { echo ', '; }
                                echo $Author;
                                $i++;
                            }
                            ?>
                        </p>
                    </div>
                    <div class="grid-item grid-padding">
                        <h2 class="text-subheader-nopt"><?= __CP('Version'); ?></h2>
                        <p><?= __CP('Plugin'); ?> <?= $Manifest->Version->Plugin; ?></p>
                        <p> <?= __CP('Saturn'); ?>
                            <?php
                            $i = 0;
                            foreach ($Manifest->Version->Saturn as $SV) {
                                if ($i !== 0) { echo ', '; }
                                echo $SV;
                                $i++;
                            }
                            ?></p>
                    </div>
                    <div class="grid-item grid-padding">
                        <h2 class="text-subheader-nopt"><?= __CP('Plugin_Compatability'); ?></h2>
                        <?php $Compatability = new PluginCompatability($Manifest); ?>

                        <?php if ($Compatability->CheckVersion()) { ?>
                            <i class="fa-solid fa-check text-green-500" aria-hidden="true"></i> Compatible with Saturn <?= SATSYS_VERSION; ?>
                        <?php } else { ?>
                            <i class="fa-solid fa-times text-red-500" aria-hidden="true"></i> Not compatible with Saturn <?= SATSYS_VERSION; ?>
                        <?php } ?><br>

                        <?php if ($Compatability->CheckUnique()) { ?>
                            <i class="fa-solid fa-check text-green-500" aria-hidden="true"></i> Unique Plugin ID
                        <?php } else { ?>
                            <i class="fa-solid fa-times text-red-500" aria-hidden="true"></i> Duplicate plugin found
                        <?php } ?><br>
                        <?php if ($Compatability->CheckConflicts()) { ?>
                            <i class="fa-solid fa-check text-green-500" aria-hidden="true"></i> No conflicts with other installed plugins
                        <?php } else { ?>
                            <i class="fa-solid fa-times text-red-500" aria-hidden="true"></i> Conflicts with other installed plugins
                        <?php } ?><br>
                    </div>
                </div>
            </div>

            <div class="grid-item grid-padding mt-4">
                <h2 class="text-subheader-nopt"><?= __CP('Settings'); ?></h2>
                <p class="mb-2"><a href="?uninstall" class="bg-red-500 hover:bg-red-400 text-white transition duration-200 px-4 py-3"><?= __CP('Uninstall'); ?></a></p>
            </div>

            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.PluginsPageEnd'); ?>
        </main>

        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
    </body>
</html>