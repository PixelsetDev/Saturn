<?php
use Saturn\ClientKit;
use Saturn\ClientKit\Translate;

new ClientKit();
$TL = new Translate();
?><!DOCTYPE html>
<html lang="<?= PANEL_LANGUAGE; ?>" class="min-h-full">
    <head>
        <?php require_once __DIR__.'/../Vendors.inc'; ?>

        <title><?= $TL->TL('SignIn'); ?> - <?= WEBSITE_NAME; ?></title>
        <?php global $Plugins; $Plugins->ExecuteHook('PANEL_HEAD_END'); ?>

    </head>
    <body class="dark:bg-black dark:text-white w-full h-full">
        <?php require_once __DIR__ . '/../Header.inc'; ?>

        <div class="flex md:flex-row flex-col w-full h-full">
            <?php require_once __DIR__ . '/../Sidebar.inc'; ?>

            <div class="h-full w-full py-8 px-10">
                <h1 class="text-3xl font-bold mb-8"><?= $TL->TL('Dashboard'); ?></h1>

                <div class="flex space-x-8">
                    <div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 w-auto p-4 bg-neutral-50 dark:bg-neutral-800">
                        <a href="/panel/pages">
                            <div class="flex items-center">
                                <div class="bg-neutral-200 dark:bg-neutral-900 h-8 w-8 rounded-full relative text-center">
                                    <div class="absolute top-[12%] left-[27%]"><i class="far fa-file fa-lg text-neutral-700 dark:text-white" aria-hidden="true"></i></div>
                                </div>
                                <p class="text-2xl ml-2">
                                    <?= $TL->TL('Pages'); ?>
                                </p>
                            </div>
                            <div class="flex flex-col justify-start">
                                <p class="text-4xl text-left font-bold my-4" id="PageCount">0</p>
                            </div>
                        </a>
                    </div>
                    <div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 w-auto p-4 bg-neutral-50 dark:bg-neutral-800">
                        <a href="/panel/articles">
                            <div class="flex items-center">
                                <div class="bg-neutral-200 dark:bg-neutral-900 h-8 w-8 rounded-full relative text-center">
                                    <div class="absolute top-[12%] left-[18%]"><i class="far fa-newspaper fa-lg text-neutral-700 dark:text-white" aria-hidden="true"></i></div>
                                </div>
                                <p class="text-2xl ml-2">
                                    <?= $TL->TL('Articles'); ?>
                                </p>
                            </div>
                            <div class="flex flex-col justify-start">
                                <p class="text-4xl text-left font-bold my-4" id="ArticleCount">0</p>
                            </div>
                        </a>
                    </div>
                    <div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 w-auto p-4 bg-neutral-50 dark:bg-neutral-800">
                        <a href="/panel/actions">
                            <div class="flex items-center">
                                <div class="bg-neutral-200 dark:bg-neutral-900 h-8 w-8 rounded-full relative text-center">
                                    <div class="absolute top-[12%] left-[18%]"><i class="fas fa-search fa-lg text-neutral-700 dark:text-white" aria-hidden="true"></i></div>
                                </div>
                                <h2 class="text-2xl ml-2">
                                    <?= $TL->TL('PendingActions'); ?>
                                </h2>
                            </div>
                            <div class="flex flex-col justify-start">
                                <p class="text-4xl text-left font-bold my-4" id="PendingActionCount">0</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="shadow-lg hover:shadow-xl transition-shadow duration-200 w-auto p-4 bg-neutral-50 dark:bg-neutral-800 mt-8">
                    <a href="/panel/analytics">
                        <div class="flex flex-col justify-start">
                            <h2 class="text-3xl font-bold mb-4"><?= $TL->TL('Analytics'); ?></h2>
                            <p class="text-xl text-left my-4">
                                0 Views today.
                            </p>
                        </div>
                    </a>
                </div>

                <div class="shadow-lg hover:shadow-xl transition-shadow duration-200 w-auto p-4 bg-neutral-50 dark:bg-neutral-800 mt-8">
                    <a href="/panel/tasks">
                        <div class="flex flex-col justify-start">
                            <h2 class="text-3xl font-bold mb-4"><?= $TL->TL('Tasks'); ?></h2>
                            <div class="text-left my-4 grid grid-cols-2 gap-4">
                                <div>
                                    <h3 class="text-xl mb-4"><?= $TL->TL('Tasks_My'); ?></h3>
                                    <p><input type="checkbox"> Complete UI</p>
                                    <p><input type="checkbox"> Make stuff work</p>
                                </div>
                                <div>
                                    <h3 class="text-xl mb-4"><?= $TL->TL('Tasks_Team'); ?></h3>
                                    <p><input type="checkbox" checked disabled> <?= $TL->TL('Tasks_Done'); ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </body>
    <?php global $API_LOCATION;?>

    <script>
        fetch('<?= $API_LOCATION; ?>/<?= API_VERSION; ?>/page/count')
            .then(response=>response.json())
            .then(data=>{ document.getElementById('PageCount').innerText = data; })
        fetch('<?= $API_LOCATION; ?>/<?= API_VERSION; ?>/article/count')
            .then(response=>response.json())
            .then(data=>{ document.getElementById('ArticleCount').innerText = data; })
        fetch('<?= $API_LOCATION; ?>/<?= API_VERSION; ?>/action/count/pending')
            .then(response=>response.json())
            .then(data=>{ document.getElementById('PendingActionCount').innerText = data; })
    </script>
</html>