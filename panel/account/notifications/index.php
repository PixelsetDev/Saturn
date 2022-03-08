<?php
session_start();
ob_start();
include_once __DIR__.'/../../../common/global_private.php';
if (isset($_GET['dismissNotif'])) {
    update_notification_dismiss(checkInput('DEFAULT', $_GET['dismissNotif']));
    header('Location: '.CONFIG_INSTALL_URL.'/panel/account/notifications');
}
ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../../common/panel/vendors.php';
            include_once __DIR__.'/../../../common/panel/theme.php';
        ?>
        <title><?php echo __('Panel:Notifications'); ?> - <?php echo __('General:Saturn'); ?> <?php echo __('Panel:Panel'); ?></title>
    </head>
    <body class="mb-8 dark:bg-neutral-700 dark:text-white">
        <?php include_once __DIR__.'/../../../common/panel/navigation.php'; ?>

        <header class="bg-white shadow dark:bg-neutral-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Notifications'); ?></h1>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 relative py-6">
            <h1 class="text-2xl leading-tight text-gray-900 dark:text-white my-8"><?php echo __('Panel:Notifications_New'); ?></h1>
            <?php
                $result = $conn->query('SELECT id FROM `'.DATABASE_PREFIX."notifications` WHERE `dismissed`='0' AND `user_id`='".$_SESSION['id']."' ORDER BY `timestamp` DESC LIMIT ".CONFIG_NOTIFICATIONS_LIMIT.';');
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_object()) {
                        foreach ($row as $r) {
                            ?>
            <div class="flex space-x-4 mb-8">
                <?php if (strpos(get_notification_title($r), 'not Approved') !== false) { ?>
                    <div class="bg-red-100 dark:bg-red-600 rounded-full w-20 h-20 text-center">
                        <i class="far fa-thumbs-down fa-2x my-6 text-red-500 dark:text-red-200" aria-hidden="true"></i>
                    </div>
                <?php } elseif (strpos(get_notification_title($r), 'Approved') !== false) { ?>
                    <div class="bg-green-100 dark:bg-green-600 rounded-full w-20 h-20 text-center">
                        <i class="far fa-thumbs-up fa-2x my-6 text-green-500 dark:text-green-200" aria-hidden="true"></i>
                    </div>
                <?php } elseif (strpos(get_notification_title($r), 'role') !== false) { ?>
                    <div class="bg-neutral-100 dark:bg-neutral-600 rounded-full w-20 h-20 text-center">
                        <i class="far fa-address-card fa-2x my-6 text-neutral-500 dark:text-neutral-200" aria-hidden="true"></i>
                    </div>
                <?php } else { ?>
                    <div class="bg-neutral-100 dark:bg-neutral-600 rounded-full w-20 h-20 text-center">
                        <i class="far fa-bell fa-2x my-6 text-neutral-500 dark:text-neutral-200" aria-hidden="true"></i>
                    </div>
                <?php } ?>
                <div>
                    <h2 class="text-xl"><?php echo get_notification_title($r); ?></h2>
                    <p><?php echo get_notification_content($r); ?></p>
                    <p class="text-xs"><?php echo get_notification_timestamp($r); ?></p>
                    <hr>
                    <a class="underline hover:text-blue-500 transition duration-200" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/account/notifications/?dismissNotif=<?php echo $r; ?>">Dismiss</a>
                </div>
            </div>
            <?php
                        }
                    }
                } else {
                    echo __('Panel:NoneFound');
                }
            ?>
            <h1 class="text-2xl leading-tight text-gray-900 dark:text-white my-8"><?php echo __('Panel:Notifications_Dismissed'); ?></h1>
            <?php
                $rs = $conn->query('SELECT id FROM `'.DATABASE_PREFIX."notifications` WHERE `dismissed`='1' AND `user_id`='".$_SESSION['id']."' ORDER BY `timestamp` DESC LIMIT ".CONFIG_NOTIFICATIONS_LIMIT.';');
                if ($rs->num_rows > 0) {
                    while ($row2 = $rs->fetch_object()) {
                        foreach ($row2 as $r2) {
                            ?>
                        <div class="flex space-x-4 mb-8">
                            <?php if (strpos(get_notification_title($r2), 'not Approved') !== false) { ?>
                            <div class="bg-red-100 dark:bg-red-600 rounded-full w-20 h-20 text-center">
                                <i class="far fa-thumbs-down fa-2x my-6 text-red-500 dark:text-red-200" aria-hidden="true"></i>
                            </div>
                            <?php } elseif (strpos(get_notification_title($r2), 'Approved') !== false) { ?>
                            <div class="bg-green-100 dark:bg-green-600 rounded-full w-20 h-20 text-center">
                                <i class="far fa-thumbs-up fa-2x my-6 text-green-500 dark:text-green-200" aria-hidden="true"></i>
                            </div>
                            <?php } elseif (strpos(get_notification_title($r2), 'role') !== false) { ?>
                            <div class="bg-neutral-100 dark:bg-neutral-600 rounded-full w-20 h-20 text-center">
                                <i class="far fa-address-card fa-2x my-6 text-neutral-500 dark:text-neutral-200" aria-hidden="true"></i>
                            </div>
                            <?php } else { ?>
                            <div class="bg-neutral-100 dark:bg-neutral-600 rounded-full w-20 h-20 text-center">
                                <i class="far fa-bell fa-2x my-6 text-neutral-500 dark:text-neutral-200" aria-hidden="true"></i>
                            </div>
                            <?php } ?>
                            <div>
                                <h2 class="text-xl"><?php echo get_notification_title($r2); ?></h2>
                                <p><?php echo get_notification_content($r2); ?></p>
                                <p class="text-xs"><?php echo get_notification_timestamp($r2); ?></p>
                            </div>
                        </div>
                        <?php
                        }
                    }
                } else {
                    echo __('Panel:NoneFound');
                }
            ?>
        </div>
    </body>
</html>