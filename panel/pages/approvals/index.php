<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include_once(__DIR__.'/../../../assets/common/global_private.php');
        include_once(__DIR__ . '/../../../assets/common/panel/vendors.php');
        include_once(__DIR__.'/../../../assets/common/panel/theme.php');
        include_once(__DIR__.'/../../../assets/common/processes/pages.php');
        ?>
        <title>Page Approvals - Saturn Panel</title>

        <?php
        if(isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 'none') {
                $errorMsg = "The page you selected has no pending approvals.";
            } else {
                $errorMsg = "Error: An unknown error occurred.";
            }
        }
        if(get_user_roleID($_SESSION['id']) < 3) {header('Location: '.CONFIG_INSTALL_URL.'/panel/pages?error=permission');}
        if(CONFIG_PAGE_APPROVALS==false) {header('Location: '.CONFIG_INSTALL_URL.'/panel/pages');}

        $key = '
                                                            <div class="text-xs text-left absolute bottom-2 left-0 h-16 w-30 p-2 bg-gray-50 rounded">
                                                                <span class="text-red-500">Red:</span> Pending Approval<br>
                                                                <span class="text-green-500">Green:</span> No Action Needed<br>
                                                                <i>You can edit pending pages.</i>
                                                            </div>'
        ?>

    </head>
    <body class="mb-8">
        <?php include_once(__DIR__.'/../../../assets/common/panel/navigation.php'); ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Page Approvals</h1>
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
                displayPageApprovalsPopout($key);
            ?>
            </div><br><hr><br>
        </div>
    </body>
</html>