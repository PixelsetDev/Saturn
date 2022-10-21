<?php
use Saturn\ClientKit\SecureArea;
use Saturn\ClientKit\Translate;

$SecureArea = new SecureArea();
$TL = new Translate();
?><!DOCTYPE html>
<html lang="<?= PANEL_LANGUAGE; ?>" class="min-h-full">
    <head>
        <?php require_once __DIR__.'/../Vendors.inc'; ?>

        <title><?= $TL->TL('Page_Editor'); ?> - <?= WEBSITE_NAME; ?></title>
        <?php global $Plugins; $Plugins->ExecuteHook('PANEL_HEAD_END'); ?>

    </head>
    <body class="dark:bg-black dark:text-white w-full min-h-screen flex flex-col">
        <?php require_once __DIR__.'/../Header.inc'; ?>

        <div class="md:grid xl:grid-cols-8 md:grid-cols-4 w-full flex-grow">
            <?php require_once __DIR__.'/../Sidebar.inc'; ?>

            <div class="h-full w-full py-8 px-10 xl:col-span-7 md:col-span-3">
                <h1 class="text-3xl font-bold mb-8"><?= $TL->TL('Page_Editor'); ?></h1>

                <div id="Editor">
                    <?php global $Plugins; $Plugins->ExecuteHook('PANEL_PAGE_EDITOR_START'); ?>

                    <?php global $Plugins; $Plugins->ExecuteHook('PANEL_PAGE_EDITOR_END'); ?>
                </div>

                <?php global $Plugins; $Plugins->ExecuteHook('PANEL_PAGE_EDITOR_BELOW'); ?>
            </div>
        </div>

        <script><?php global $API_LOCATION; ?>
            fetch('<?= $API_LOCATION; ?>/<?= API_VERSION; ?>/page/<?= $id; ?>')
                .then(response=>response.text())
                .then(data=>{
                    const JSONData = JSON.parse(data);
                    console.log(JSONData);
                    document.getElementById("PageList").innerHTML = List;
                })
        </script>
    </body>
</html>