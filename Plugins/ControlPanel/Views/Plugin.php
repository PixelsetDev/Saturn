<?php
use Saturn\HookManager\Actions;
use Saturn\PluginManager\PluginCompatability;
use Saturn\PluginManager\PluginManifest;
require_once __DIR__ . '/Include/Security.php';
$Slug = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$PM = new PluginManifest();
$Manifest = $PM->GetManifest($Slug);

global $SaturnPlugins;
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= __CP('Plugins'); ?> - <?= WEBSITE_NAME ?> <?= __CP('ControlPanel'); ?></title>

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
                        <p><?= $Manifest->Version->Plugin; ?></p>
                    </div>
                    <div class="grid-item grid-padding">
                        <h2 class="text-subheader-nopt"><?= __CP('Plugin_Compatability'); ?></h2>
                        <?php $Compatability = new PluginCompatability($Manifest); ?>

                        <?php if ($Compatability->CheckVersion()) { ?><i class="fa-solid fa-check"></i><?php } else { ?><i class="fa-solid fa-times"></i><?php } ?> Compatible with Saturn <?= SATSYS_VERSION; ?><br>
                        <?php if ($Compatability->CheckDuplicate()) { ?><i class="fa-solid fa-check"></i><?php } else { ?><i class="fa-solid fa-times"></i><?php } ?> Unique Plugin ID<br>
                        <?php if ($Compatability->CheckConflicts()) { ?><i class="fa-solid fa-check"></i><?php } else { ?><i class="fa-solid fa-times"></i><?php } ?> Conflicts with other installed plugins<br>
                    </div>
                </div>
            </div>

            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.PluginsPageEnd'); ?>
        </main>

        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Statistics.js"></script>
    </body>
</html>