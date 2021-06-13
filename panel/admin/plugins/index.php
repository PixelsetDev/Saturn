<?php
    session_start();
    ob_start();
    require_once __DIR__ . '/../../../assets/common/global_private.php';
    require_once __DIR__ . '/../../../assets/common/processes/gui/modals.php';
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__ . '/../../../assets/common/panel/vendors.php'; ?>

        <title><?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__ . '/../../../assets/common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__ . '/../../../assets/common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl">Plugins</h1>
            <?php
                if(isset($errorMsg)){
                    alert('ERROR', $errorMsg);
                    unset($errorMsg);
                }
                if(isset($successMsg)){
                    alert('SUCCESS', $successMsg);
                    unset($successMsg);
                }
            ?>
            <br>
            <h2 class="text-gray-900 text-2xl mt-8">Installed Plugins</h2>
            <h2 class="text-gray-900 text-2xl mt-8">Plugin Marketplace</h2>
            <div class="my-6 flex space-x-3 p-3 bg-white rounded-t-md overflow-x-scroll">
                <?php echo file_get_contents('https://www.marketplace.saturncms.net/plugins/embed'); ?>
            </div>
        </div>
    </body>
</html>