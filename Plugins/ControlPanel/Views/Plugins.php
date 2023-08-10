<?php
use Saturn\HookManager\Actions;
use Saturn\PluginManager\PluginManifest;
require_once __DIR__ . '/Include/Security.php';
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
            <h1 class="text-header-nopt"><?= __CP('Plugins'); ?></h1>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.PluginsListStart'); ?>
            <div class="grid grid-cols-1 gap-2">
                <?php
                    global $SaturnPlugins;
                    foreach ($SaturnPlugins as $Plugin => $Loaded) {
                        $PM = new PluginManifest();
                        $Manifest = $PM->GetManifest($Plugin);
                ?>
                <a class="grid-item-link grid-padding relative" href="<?= SATURN_ROOT; ?>/panel/plugins/<?= $Manifest->Slug; ?>">
                    <h2 class="text-3xl font-bold"><?= $Manifest->Name; ?></h2>
                    <p class="pb-2">
                        <strong><?= $Manifest->Description; ?></strong>
                    </p>
                    <p>
                        <?= __CP('By'); ?>
                        <?php
                            $i = 0;
                            foreach ($Manifest->Author as $Author) {
                                if ($i !== 0) { echo ', '; }
                                echo $Author;
                                $i++;
                            }
                        ?>
                    </p>
                    <p>
                        <?= __CP('Version'); ?> <?= $Manifest->Version->Plugin; ?> <?= __CP('ForSaturn'); ?>
                        <?php
                            $i = 0;
                            foreach ($Manifest->Version->Saturn as $SV) {
                                if ($i !== 0) { echo ', '; }
                                echo $SV;
                                $i++;
                            }
                        ?>
                    </p>
                    <?php if (!$Loaded['Loaded']) { ?>
                    <div class="absolute top-0 right-0 px-2 py-1 bg-yellow-300 text-black">
                        Unloaded
                    </div>
                    <?php } ?>
                </a>
                <?php } ?>
            </div>
            <?php $Actions = new Actions(); $Actions->Run('ControlPanel.PluginsListEnd'); ?>
        </main>

        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Statistics.js"></script>
    </body>
</html>