<?php
    session_start();
    require_once __DIR__ . '/../../../assets/common/global_private.php';
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

            <h1 class="text-gray-900 text-3xl">Security Log</h1>
            <br>
            <iframe src="<?php echo CONFIG_INSTALL_URL; ?>/assets/storage/security_log.txt" class="w-full h-3/4 overflow-scroll" title="Security Log">
        </div>
    </body>
</html>