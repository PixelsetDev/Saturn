<?php
use Saturn\ClientKit\SecureArea;
use Saturn\ClientKit\Translate;

$SecureArea = new SecureArea();
$TL = new Translate();
?><!DOCTYPE html>
<html lang="<?= PANEL_LANGUAGE; ?>" class="min-h-full">
    <head>
        <?php require_once __DIR__.'/../Vendors.inc'; ?>

        <title><?= $TL->TL('Pages'); ?> - <?= WEBSITE_NAME; ?></title>
        <?php global $Plugins; $Plugins->ExecuteHook('PANEL_HEAD_END'); ?>

    </head>
    <body class="dark:bg-black dark:text-white w-full h-full">
        <?php require_once __DIR__.'/../Header.inc'; ?>

        <div class="flex md:flex-row flex-col w-full h-full">
            <?php require_once __DIR__.'/../Sidebar.inc'; ?>

            <div class="h-full w-full py-8 px-10">
                <h1 class="text-3xl font-bold mb-7"><?= $TL->TL('Pages'); ?></h1>

                <div id="PageList">

                </div>
            </div>
        </div>

        <script><?php global $API_LOCATION; ?>
            var List = document.getElementById("PageList").innerHTML;

            fetch('<?= $API_LOCATION; ?>/<?= API_VERSION; ?>/page/list')
                .then(response=>response.text())
                .then(data=>{
                    const JSONData = JSON.parse(data);
                    for(var i in JSONData) {
                        let ml = 0;
                        if (JSONData[i].parent != null) { ml = '8'; }
                        List = List + `<div class="px-3 py-2 my-1 ml-`+ml+` bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                        <p class="flex-grow self-center">`+JSONData[i].title+`</p>
                        <a href="/panel/pages/edit/?id=`+JSONData[i].id+`" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                            <i class="fas fa-pencil" aria-hidden="true"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Edit</span>
                        </a>
                        <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                            <i class="fas fa-trash-can" aria-hidden="true"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Delete</span>
                        </a>
                        <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                            <i class="fa-solid fa-arrows-up-down-left-right"></i>
                        </a>
                    </div>`;
                    }
                    document.getElementById("PageList").innerHTML = List;
                })


        </script>
    </body>
</html>