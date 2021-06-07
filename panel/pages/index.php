<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once(__DIR__.'/../../assets/common/global_private.php');
            include_once(__DIR__ . '/../../assets/common/panel/vendors.php');
            include_once(__DIR__.'/../../assets/common/panel/theme.php');
            include_once(__DIR__.'/../../assets/common/processes/pages.php');
        ?>
        <title>Pages - Saturn Panel</title>

        <?php
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error == 'permission') {
                    $errorMsg = "Error: You do not have the required permissions to do that.";
                } else if ($error == 'new') {
                    $errorMsg = "Error: There was a problem creating a new page.";
                } else {
                    $errorMsg = "Error: An unknown error occurred.";
                }
            }

            $key = '
                                                        <div class="text-xs text-left absolute bottom-2 left-0 h-16 w-30 p-2 bg-gray-50 rounded">
                                                            <span class="text-red-500">Red:</span> No Content<br>
                                                            <span class="text-yellow-500">Yellow:</span> Pending Approval<br>
                                                            <span class="text-green-500">Green:</span> Currently Live<br>
                                                            <i>You can edit pending pages.</i>
                                                        </div>'
        ?>

    </head>
    <body class="mb-8">
        <?php include_once(__DIR__.'/../../assets/common/panel/navigation.php'); ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Pages</h1>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <?php
                if(isset($errorMsg)){
                    alert('ERROR',$errorMsg);
                }
                unset($errorMsg);
            ?>
            <div class="px-4 py-6 sm:px-0">
                <?php
                    displayPageEditorPopout($key);
                ?>
                </div>
                <br><hr><br>
            </div>
    </body>
</html>