<?php session_start();
    ob_start();

    include_once(__DIR__.'/../../../../assets/common/global_private.php');
    include_once(__DIR__.'/../../../../assets/common/processes/gui/modals.php');

    $pageID = checkInput('DEFAULT', $_GET['pageID']);

    if(empty($_SERVER['CONTENT_TYPE'])) {
        $_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
    }

    if((get_page_pending_title($pageID) == NULL) AND (get_page_pending_content($pageID) == NULL)) {
        header('Location: '.CONFIG_INSTALL_URL.'/panel/pages/approvals/?error=none');
    }

    if(isset($_POST['approve'])) {
        $title = get_page_pending_title($pageID);
        $content = get_page_pending_content($pageID);
        $references = get_page_pending_references($pageID);
        $uid = get_page_pending_user_id($pageID);
        $query = "UPDATE `".DATABASE_PREFIX."pages` SET `title`='$title',`content`='$content',`reference`='$references',`user_id`='$uid' WHERE `id`='$pageID';";
        $rs = mysqli_query($conn,$query);
        $query = "INSERT INTO `".DATABASE_PREFIX."pages_history` (`id`, `page_id`, `user_id`, `timestamp`) VALUES (NULL, '".$pageID."', '".$uid."', CURRENT_TIMESTAMP)";
        $rs = mysqli_query($conn,$query);
        $query = "UPDATE `".DATABASE_PREFIX."pages_pending` SET `title` = NULL, `content` = NULL, `reference` = NULL, `user_id` = NULL WHERE `id` = ".$pageID;
        $rs = mysqli_query($conn,$query);
        $newEdits = get_user_edits($uid)+1;
        update_user_edits($uid, $newEdits);
        $newApprovals = get_user_approvals($uid)+1;
        update_user_approvals($_SESSION['id'], $newApprovals);
        create_notification($uid, 'Edit Approved', 'Your edit for page "'.get_page_title($pageID). '" was approved by '.get_user_fullname($_SESSION['id']).'.');
        log_all('SATURN][PAGES',get_user_fullname($_SESSION['id']).' approved page edit for page ID: '.$pageID.' ('.get_page_title($pageID).') requested by '.get_user_fullname($uid).'.');
        header('Location: '.CONFIG_INSTALL_URL.'/panel/pages/approvals');
        exit;
    } else if(isset($_POST['deny'])) {
        $uid = get_page_pending_user_id($pageID);
        $query = "UPDATE `".DATABASE_PREFIX."pages_pending` SET `title` = NULL, `content` = NULL, `reference` = NULL, `user_id` = NULL WHERE `id` = ".$pageID;
        $rs = mysqli_query($conn,$query);
        $newApprovals = get_user_approvals($uid)+1;
        update_user_approvals($_SESSION['id'], $newApprovals);
        create_notification($uid, 'Edit not Approved', 'Your edit for page "'.get_page_title($pageID). '" was not approved.');
        log_all('SATURN][PAGES',get_user_fullname($_SESSION['id']).' denied page edit for page ID: '.$pageID.' ('.get_page_title($pageID).') requested by '.get_user_fullname($uid).'.');
        header('Location: '.CONFIG_INSTALL_URL.'/panel/pages/approvals');
        exit;
    }
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include_once(__DIR__ . '/../../../../assets/common/panel/vendors.php');
        include_once(__DIR__.'/../../../../assets/common/panel/theme.php');
        ?>

        <title>Page Approvals - Saturn Panel</title>

    </head>
    <body class="mb-8">
        <?php include_once(__DIR__.'/../../../../assets/common/panel/navigation.php'); ?>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Page Approval: <?php $title = get_page_title($pageID); $title = mysqli_real_escape_string($conn, $title); echo $title; ?></h1>
                <p>Requested by <?php echo get_user_fullname(get_page_pending_user_id($pageID)); ?>.</p>
            </div>
        </header>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>/?pageID=<?php echo $pageID; ?>" method="POST" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <?php if(isset($_GET['error'])) { echo '<br><div class="duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                                        <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                            <h6 class="mb-2 font-semibold leading-5">'.$_GET['error'].'</h6>
                                        </div>
                                    </div><br>';} else if(isset($_GET['success'])) { echo '<br><div class="duration-300 transform bg-green-100 border-l-4 border-green-500 hover:-translate-y-2">
                                        <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                            <h6 class="mb-2 font-semibold leading-5">'.$_GET['success'].'</h6>
                                        </div>
                                    </div><br>';} ?>
            <div class="flex space-x-4 my-2">
                <div class="w-1/2 border-2 border-<?php echo THEME_PANEL_COLOUR; ?>-200 p-2">
                    <h2 class="text-4xl mb-2 font-bold">Current / Existing Page</h2>
                    <div class="py-6">
                        <h2 class="text-2xl mb-2 font-bold my-2">
                            <span name="title" id="title" maxlength="60" class="w-full border"><?php
                                $title = get_page_title($pageID);
                                $title = checkOutput('HTML', $title); echo $title;
                                unset($title);
                                ?>
                            </span>
                        </h2>
                    </div>

                    <div class="py-6">
                        <span name="content" id="content"><?php
                            $content = get_page_content($pageID);
                            $content = checkOutput('HTML', $content); echo $content;
                            unset($content);
                            ?>
                        </span>
                    </div>

                    <div class="py-6">
                        <h2 class="text-2xl font-bold mt-2">References</h2>
                        <span name="references" id="references"><?php
                            $references = get_page_references($pageID);
                            $references = checkOutput('HTML', $references); echo $references;
                            unset($references);
                            ?>
                        </span>
                    </div>
                </div>

                <div class="w-1/2 border-2 border-<?php echo THEME_PANEL_COLOUR; ?>-200 p-2">
                    <h2 class="text-4xl mb-2 font-bold">Pending Approval</h2>
                    <div class="py-6">
                        <h2 class="text-2xl mb-2 font-bold my-2">
                            <span name="title" id="title" maxlength="60" class="w-full border"><?php
                                $pageStatus = get_page_status($pageID);
                                if ($pageStatus == 'green' OR CONFIG_PAGE_APPROVALS == false) {
                                    $title = get_page_title($pageID);
                                    $title = checkOutput('HTML', $title); echo $title;
                                } else if ($pageStatus == 'yellow') {
                                    $title = get_page_pending_title($pageID);
                                    $title = checkOutput('HTML', $title); echo $title;
                                }
                                unset($title);
                                ?>
                            </span>
                        </h2>
                    </div>

                    <div class="py-6">
                        <span name="content" id="content"><?php
                            if ($pageStatus == 'green' OR CONFIG_PAGE_APPROVALS == false) {
                                $content = get_page_content($pageID);
                                $content = checkOutput('HTML', $content); echo $content;
                            } else if ($pageStatus == 'yellow') {
                                $content = get_page_pending_content($pageID);
                                $content = checkOutput('HTML', $content); echo $content;
                            }
                            unset($content);
                            ?>
                        </span>
                    </div>

                    <div class="py-6">
                        <h2 class="text-2xl font-bold mt-2">References</h2>
                        <span name="references" id="references"><?php
                            if ($pageStatus == 'green' OR CONFIG_PAGE_APPROVALS == false) {
                                $references = get_page_references($pageID);
                                $references = checkOutput('HTML', $references); echo $references;
                            } else if ($pageStatus == 'yellow') {
                                $references = get_page_pending_references($pageID);
                                $references = checkOutput('HTML', $references); echo $references;
                            }
                            unset($references);
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex space-x-4 flex-nowrap">
                <div x-data="{ open: false }">
                    <a @click="open = true" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">Deny Changes</a>
                    <?php echo display_modal('red', 'Deny Changes', 'Are you sure you want to deny all changes to this page?<br> This action cannot be undone.', '<div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <input type="submit" id="deny" name="deny" value="Deny Changes" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">Cancel</a>
                                </div>'); ?>
                </div>
                <div x-data="{open:false}">
                    <a @click="open = true" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 md:py-1 md:text-rg md:px-10">Approve Changes</a>
                    <?php echo display_modal('green', 'Approve Changes', 'Are you sure you want to approve all changes to this page?<br> This action cannot be undone.', '<div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <input type="submit" id="approve" name="approve" value="Approve Changes" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 md:py-1 md:text-rg md:px-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">Cancel</a>
                                </div>'); ?>
                </div>
            </div>
        </form>
    </body>
</html>