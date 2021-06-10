<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once(__DIR__.'/../../../assets/common/global_private.php');
            include_once(__DIR__ . '/../../../assets/common/panel/vendors.php');
            include_once(__DIR__.'/../../../assets/common/panel/theme.php');
        ?>
        <title>Notifications - Saturn Panel</title>
    </head>
    <body class="mb-8">
        <?php
            include_once(__DIR__.'/../../../assets/common/panel/navigation.php');
            if(isset($_GET['dismissNotif'])){
                $nid = checkInput('DEFAULT',$_GET['dismissNotif']);update_notification_dismiss($nid);header('Location: '.CONFIG_INSTALL_URL.'/panel/account/notifications');
            }
        ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Notifications</h1>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 relative py-6">
            <?php
                $notifCount = get_notification_count($_SESSION['id']);
                if($notifCount > '0') {
                    echo'<a href="'.CONFIG_INSTALL_URL.'/panel/account/notifications/?dismissNotif='.get_notification_id($_SESSION['id']).'" class="m-1 bg-white rounded-lg border-gray-300 border p-3 shadow-lg max-w-sm md:max-w-xl max-h-20 overflow-y-scroll absolute top-0 left-0">
                <div class="flex flex-row">
                    <div class="animate-pulse px-2 bg-blue-500 rounded-full w-6 h-6 text-white text-center">
                        <i class="fas fa-info"></i>
                    </div>
                    <div class="ml-2 mr-6">
                        <div class="flex w-full"><span class="font-semibold w-11/12">'.get_notification_title($_SESSION['id']).'</span><span class="w-1/12 text-red-500">x</span></div>
                        <span class="block text-gray-500">'.get_notification_content($_SESSION['id']).'</span>
                    </div>
                </div>
            </a>';
                } else {
                    echo'<p>You don\'t have any notifications.</p>';
                }
            ?>
        </div>
    </body>
</html>