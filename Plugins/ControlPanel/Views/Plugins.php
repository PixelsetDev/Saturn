<?php
use Saturn\HookManager\Actions;
use Saturn\PluginManager\PluginManifest;
require_once __DIR__ . '/Include/Security.php';
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= __CP('Plugins'); ?> - <?= WEBSITE_NAME ?> <?= __CP('ControlPanel'); ?></title>
        <?php require_once __DIR__ . '/Include/Header.php'; ?>
    </head>
    <body class="body">
        <?php require_once __DIR__ . '/Include/Navigation.php'; ?>
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
    </body>
</html>