<?php session_start();
    ob_start();

    include_once __DIR__.'/../../../../common/global_private.php';
    include_once __DIR__.'/../../../../common/processes/gui/modals.php';

    $articleID = checkInput('DEFAULT', $_GET['articleID']);

    if (empty($_SERVER['CONTENT_TYPE'])) {
        $_SERVER['CONTENT_TYPE'] = 'application/x-www-form-urlencoded';
    }

    if (get_article_status($articleID) != 'PENDING') {
        header('Location: '.CONFIG_INSTALL_URL.'/panel/articles/approvals/?error=none');
    }

    if (get_user_roleID($_SESSION['id']) < 3) {
        header('Location: '.CONFIG_INSTALL_URL.'/panel/pages?error=permission');
    }

    $uid = get_article_author_id($articleID);

    if (isset($_POST['approve'])) {
        update_article_status($articleID, 'PUBLISHED');

        $newEdits = get_user_statistics_edits($uid) + 1;
        update_user_edits($uid, $newEdits);

        $newApprovals = get_user_statistics_approvals($_SESSION['id']) + 1;
        update_user_approvals($_SESSION['id'], $newApprovals);

        create_notification($uid, __('Panel:Article_Approvals_Approved'), __('Panel:Article_Approvals_Approved_Message_1').' "'.get_article_title($articleID).'" '.__('Panel:Article_Approvals_Approved_Message_2').' '.get_user_fullname($_SESSION['id']).'.');

        log_all('SATURN][ARTICLES', get_user_fullname($_SESSION['id']).' '.__('Panel:Article_Approvals_Approved_Log_1').' '.$articleID.' ('.get_page_title($articleID).') '.__('Panel:Article_Approvals_Approved_Log_2').' '.get_user_fullname($uid).'.');
        header('Location: '.CONFIG_INSTALL_URL.'/panel/articles/approvals');
        exit;
    } elseif (isset($_POST['deny'])) {
        update_article_status($articleID, 'REJECTED');

        $newApprovals = get_user_statistics_approvals($_SESSION['id']) + 1;
        update_user_approvals($_SESSION['id'], $newApprovals);

        create_notification($uid, __('Panel:Article_Approvals_Declined'), __('Panel:Article_Approvals_Declined_Message_1').' "'.get_article_title($articleID).'" '.__('Panel:Article_Approvals_Approved_Message_2'));

        log_all('SATURN][ARTICLES', get_user_fullname($_SESSION['id']).' '.__('Panel:Article_Approvals_Declined_Log_1').' '.$articleID.' ('.get_page_title($articleID).') '.__('Panel:Article_Approvals_Declined_Log_2').' '.get_user_fullname($uid).'.');
        header('Location: '.CONFIG_INSTALL_URL.'/panel/articles/approvals');
        exit;
    }
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../../../common/panel/vendors.php';
            include_once __DIR__.'/../../../../common/panel/theme.php';
        ?>

        <title><?php echo __('Panel:Article_Approvals'); ?> - <?php echo __('General:Saturn').' '.__('Admin:Panel'); ?></title>
    </head>
    <body class="mb-8 dark:text-white dark:bg-neutral-700">
        <?php include_once __DIR__.'/../../../../common/panel/navigation.php'; ?>
        <header class="bg-white shadow dark:bg-neutral-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Article_Approval'); ?> <?php echo get_article_title($articleID); ?></h1>
                <p><?php echo __('Panel:Article_Approvals_RequestedBy'); ?> <?php echo get_user_fullname(get_article_author_id($articleID)); ?>.</p>
            </div>
        </header>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>/?articleID=<?php echo $articleID; ?>" method="POST" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <?php if (isset($_GET['error'])) {
            echo alert('ERROR', $_GET['error']);
            log_error('ERROR', checkInput('DEFAULT', $_GET['error']));
        } elseif (isset($_GET['success'])) {
            echo alert('SUCCESS', $_GET['success']);
        } ?>
            <div class="flex space-x-4 my-2">
                <div class="w-full border-2 border-<?php echo THEME_PANEL_COLOUR; ?>-200 p-2">
                    <h2 class="text-4xl mb-2 font-bold"><?php echo __('Panel:PendingPublication'); ?></h2>
                    <div class="py-6">
                        <h2 class="text-2xl mb-2 font-bold my-2">
                            <span name="title" id="title" maxlength="60" class="w-full border">
                                <?php
                                    $title = get_article_title($articleID);
                                    echo stripslashes(checkOutput('HTML', $title));
                                    unset($title);
                                ?>
                            </span>
                        </h2>
                    </div>

                    <div class="py-6">
                        <span name="content" id="content">
                            <?php
                                $content = get_article_content($articleID);
                                $content = checkOutput('HTML', $content); echo stripslashes($content);
                                unset($content);
                            ?>
                        </span>
                    </div>

                    <div class="py-6">
                        <h2 class="text-2xl font-bold mt-2"><?php echo __('Panel:References'); ?></h2>
                        <span name="references" id="references">
                            <?php
                                $references = get_article_references($articleID);
                                $references = checkOutput('HTML', $references); echo stripslashes($references);
                                unset($references);
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex space-x-4 flex-nowrap">
                <div x-data="{ open: false }">
                    <a @click="open = true" class="transition-all cursor-pointer duration-200 hover:shadow-lg w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 dark:text-white bg-red-200 dark:bg-red-700 dark:hover:bg-red-600 hover:bg-red-300 md:py-1 md:text-rg md:px-10"><?php echo __('Panel:Article_Approvals_Decline'); ?></a>
                    <?php echo display_modal('red', __('Panel:Article_Approvals_Decline'), __('Panel:Article_Approvals_Decline_Message').'<br>'.__('General:CannotBeUndone'), '<div class="bg-gray-50 dark:bg-neutral-600 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                            <input type="submit" id="deny" name="deny" value="'.__('Panel:Deny').'" class="transition-all cursor-pointer duration-200 hover:shadow-lg w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 dark:text-white bg-red-200 dark:bg-red-700 dark:hover:bg-red-600 hover:bg-red-300 md:py-1 md:text-rg md:px-10">
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a @click="open=false" class="dark:bg-neutral-800 dark:text-white dark:hover:bg-neutral-700 flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-900 bg-gray-200 hover:bg-gray-300 md:py-1 md:text-rg md:px-10">'.__('General:Cancel').'</a>
                                        </div>'); ?>
                </div>
                <div x-data="{open:false}">
                    <a @click="open = true" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-900 dark:text-white bg-green-200 dark:bg-green-700 dark:hover:bg-green-600 hover:bg-green-300 md:py-1 md:text-rg md:px-10"><?php echo __('Panel:Article_Approvals_Approve'); ?></a>
                    <?php echo display_modal('green', __('Panel:Article_Approvals_Approve'), __('Panel:Article_Approvals_Approve_Message').'<br>'.__('General:CannotBeUndone'), '<div class="bg-gray-50 dark:bg-neutral-600 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                            <input type="submit" id="approve" name="approve" value="'.__('Panel:Approve').'" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-900 dark:text-white bg-green-200 dark:bg-green-700 dark:hover:bg-green-600 hover:bg-green-300 md:py-1 md:text-rg md:px-10">
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a @click="open=false" class="dark:bg-neutral-800 dark:text-white dark:hover:bg-neutral-700 flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-900 bg-gray-200 hover:bg-gray-300 md:py-1 md:text-rg md:px-10">'.__('General:Cancel').'</a>
                                        </div>'); ?>
                </div>
            </div>
        </form>
    </body>
</html>