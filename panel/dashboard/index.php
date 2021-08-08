<?php
session_start();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../assets/common/global_private.php';
            include_once __DIR__.'/../../assets/common/panel/vendors.php';
            include_once __DIR__.'/../../assets/common/panel/theme.php';
            $id = $_SESSION['id'];
        ?>
        <title>Saturn Panel</title>

        <?php
            if (isset($_GET['dismissNotif'])) {
                $nid = $_GET['dismissNotif'];
                update_notification_dismiss($nid);
                header('Location: '.CONFIG_INSTALL_URL.'/panel/dashboard');
            }
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error == 'permission') {
                    $errorMsg = 'You do not have the required permissions to do that.';
                } elseif ($error == 'no_user') {
                    $errorMsg = 'User not found.';
                } else {
                    $errorMsg = 'An unknown error occurred.';
                }
            }
            if (isset($_GET['warning'])) {
                $error = $_GET['warning'];
                if ($error == 'permission') {
                    $errorMsg = 'You do not have the required permissions to do that.';
                } else {
                    $warningMsg = 'An unknown warning occurred.';
                }
            }
        ?>

    </head>
    <body class="mb-14">
        <?php include_once __DIR__.'/../../assets/common/panel/navigation.php'; ?>

        <header class="bg-white shadow relative <?php $notifCount = get_notification_count($_SESSION['id']); if ($notifCount > '0') {
            echo 'pb-28 md:pb-1';
        } ?>">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Dashboard</h1>
            </div>
            <?php if ($notifCount > '0') {
            echo'<a href="'.CONFIG_INSTALL_URL.'/panel/dashboard/?dismissNotif='.get_notification_id($_SESSION['id']).'" class="m-1 bg-white rounded-lg border-gray-300 border p-3 shadow-lg absolute md:top-0 right-0 max-w-sm md:max-w-xl max-h-20 overflow-y-scroll">
                <div class="flex flex-row">
                    <div class="animate-pulse px-2 bg-blue-500 rounded-full w-6 h-6 text-white text-center">
                        <i class="fas fa-info" aria-hidden="true"></i>
                    </div>
                    <div class="ml-2 mr-6">
                        <div class="flex w-full"><span class="font-semibold w-11/12">'.get_notification_title($_SESSION['id']).'</span><span class="w-1/12 text-red-500">x</span></div>
                        <span class="block text-gray-500">'.get_notification_content($_SESSION['id']).'</span>
                    </div>
                </div>
            </a>';
        }
            ?>
        </header>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <?php
            if (isset($errorMsg)) {
                alert('ERROR', $errorMsg);
                unset($errorMsg);
            }
            if (isset($warningMsg)) {
                alert('WARNING', $warningMsg);
                unset($warningMsg);
            }
            if (CONFIG_DEBUG) {
                alert('WARNING', 'Debug mode is enabled. This is NOT recommended in production environments.');
            }
            if (get_user_roleID($_SESSION['id']) > 3) {
                $remoteVersion = file_get_contents('https://link.saturncms.net/?latest_version=beta');
                $localVersion = file_get_contents(__DIR__.'/../../assets/common/version.txt');
                if ($remoteVersion != $localVersion) {
                    echo '<br>
                    <div class="w-full mr-1 my-1 duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                        <div class="h-full p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">An update is available.</h6>
                            <a href="'.CONFIG_INSTALL_URL.'/panel/admin" class="text-'.THEME_PANEL_COLOUR.'-500 hover:text-'.THEME_PANEL_COLOUR.'-400 underline">Update</a>.
                        </div>
                    </div>';
                }
            }
            ?>

            <div class="flex flex-wrap space-x-4">
                <div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-2xl w-auto p-4 bg-white dark:bg-gray-800">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/pages">
                        <div class="flex items-center">
                            <span class="bg-green-500 px-3 py-2 h-10 w-10 rounded-full relative">
                                <i class="far fa-file fa-lg text-white" aria-hidden="true"></i>
                            </span>
                            <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                                Pages
                            </p>
                        </div>
                        <div class="flex flex-col justify-start">
                            <p class="text-gray-800 text-4xl text-left dark:text-white font-bold my-4">
                                <?php
                                    $result = mysqli_query($conn, 'SELECT * FROM `'.DATABASE_PREFIX.'pages` WHERE 1;');
                                    $rowCount = mysqli_num_rows($result);
                                    echo $rowCount;
                                ?>
                            </p>
                        </div>
                    </a>
                </div>

                <div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-2xl w-auto p-4 bg-white dark:bg-gray-800 ml-4">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/articles">
                        <div class="flex items-center">
                            <span class="bg-green-500 px-2 py-2 h-10 w-10 rounded-full relative">
                                <i class="far fa-newspaper fa-lg text-white" aria-hidden="true"></i>
                            </span>
                            <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                                Articles
                            </p>
                        </div>
                        <div class="flex flex-col justify-start">
                            <p class="text-gray-800 text-4xl text-left dark:text-white font-bold my-4">
                                <?php
                                    $result = mysqli_query($conn, 'SELECT * FROM `'.DATABASE_PREFIX."articles` WHERE `author_id` = '".$_SESSION['id']."';");
                                    $rowCount = mysqli_num_rows($result);
                                    echo $rowCount;
                                ?>
                            </p>
                        </div>
                    </a>
                </div>

                <?php if (get_user_roleID($_SESSION['id']) > 2) { ?>
                <div x-data="{ open: false }" class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-2xl w-auto p-4 bg-white dark:bg-gray-800">
                    <a @click="open = true" class="cursor-pointer">
                        <div class="flex items-center">
                            <span class="bg-green-500 px-2 py-2 h-10 w-10 rounded-full relative">
                                <i class="fas fa-search fa-lg text-white" aria-hidden="true"></i>
                            </span>
                            <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                                Pending <br class="md:hidden block">Approvals
                            </p>
                        </div>
                        <div class="flex flex-col justify-start">
                            <p class="text-gray-800 text-4xl text-left dark:text-white font-bold my-4">
                                <?php
                                    $result = mysqli_query($conn, 'SELECT `content` FROM `'.DATABASE_PREFIX.'pages_pending` WHERE `content` IS NOT NULL;');
                                    $rows = mysqli_num_rows($result);

                                    $result2 = mysqli_query($conn, 'SELECT * FROM `'.DATABASE_PREFIX."articles` WHERE `status` = 'PENDING';");
                                    $rows2 = mysqli_num_rows($result2);

                                    $finalRows = $rows + $rows2;
                                    echo $finalRows;

                                    unset($result, $result2, $rows, $rows2, $finalRows);
                                ?>
                            </p>
                        </div>
                    </a>
                    <?php echo display_modal('INFO', 'Approvals', 'Please select a format to view approvals for.', '<div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <a href="'.CONFIG_INSTALL_URL.'/panel/articles/approvals" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 bg-'.THEME_PANEL_COLOUR.'-100 hover:bg-'.THEME_PANEL_COLOUR.'-200 md:py-1 md:text-rg md:px-10">Article Approvals</a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="'.CONFIG_INSTALL_URL.'/panel/pages/approvals" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 bg-'.THEME_PANEL_COLOUR.'-100 hover:bg-'.THEME_PANEL_COLOUR.'-200 md:py-1 md:text-rg md:px-10">Page Approvals</a>
                                </div>'); ?>
                </div>
                <?php } ?>
            </div>
            <div class="flex flex-wrap space-x-4">
                <?php
                    $result = mysqli_query($conn, 'SELECT `id`, `edits` FROM `'.DATABASE_PREFIX.'users_statisticcs` WHERE 1 ORDER BY edits;');
                    $row = mysqli_fetch_row($result);
                    $uid = $row[0];
                ?>
                <div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-xl w-full md:w-80 p-4 bg-white dark:bg-gray-800 relative overflow-hidden mt-4">
                    <div class="flex items-center">
                        <span class="bg-green-500 px-3 py-2 h-10 w-10 rounded-full relative">
                            <i class="fas fa-pencil-alt fa-lg text-white" aria-hidden="true"></i>
                        </span>
                        <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                            Top Writers
                        </p>
                    </div>
                    <div class="flex space-x-4">
                        <?php
                            $x = 0;
                            $result = mysqli_query($conn, 'SELECT `id`, `edits` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE 1 ORDER BY edits DESC;');
                            $row = mysqli_fetch_row($result);
                            $uid = $row[0];
                            while ($uid != null && $x != '4') {
                                if (get_user_roleID($uid) != '0' && get_user_roleID($uid) != '1') {
                                    echo '<div class="flex-grow">
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    <a href="'.get_user_profile_link($uid).'" class="block relative">
                                        <img alt="'.get_user_fullname($uid).'" src="'.get_user_profilephoto($uid).'" class="mx-auto object-cover rounded-full h-10 w-10 "/>
                                    </a>
                                </div>
                                <a href="'.get_user_profile_link($uid).'" class="text-gray-600 dark:text-gray-400 text-xs mt-2">
                                    '.get_user_fullname($uid).'
                                </a>
                                <a href="'.get_user_profile_link($uid).'" class="mt-1 text-xs text-white bg-';
                                    if (get_user_statistics_edits($uid) == '0') {
                                        echo 'red';
                                    } elseif (get_user_statistics_edits($uid) < '6') {
                                        echo 'yellow';
                                    } else {
                                        echo 'green';
                                    }
                                    echo'-500 rounded-full p-1">
                                    '.$row[1].' Edits
                                </a>
                            </div>
                        </div>';
                                }
                                $row = mysqli_fetch_row($result);
                                if (isset($row[0])) {
                                    $uid = $row[0];
                                }
                                $x++;
                            }
                        ?>
                    </div>
                </div><?php
                if (get_user_roleID($id) > '2') {
                    $result = mysqli_query($conn, 'SELECT `id`, `edits` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE 1 ORDER BY edits;');
                    $row = mysqli_fetch_row($result);
                    $uid = $row[0];
                    echo '<div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-xl w-full md:w-80 p-4 bg-white dark:bg-gray-800 relative overflow-hidden mt-4">
                    <div class="flex items-center">
                        <span class="bg-green-500 px-3 py-2 h-10 w-10 rounded-full relative">
                            <i class="fas fa-pencil-ruler fa-lg text-white" aria-hidden="true"></i>
                        </span>
                        <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                            Top Editors
                        </p>
                    </div>
                    <div class="flex space-x-4">';
                    $x = 0;
                    $result = mysqli_query($conn, 'SELECT `id`, `approvals` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE 1 ORDER BY approvals DESC;');
                    $row = mysqli_fetch_row($result);
                    $uid = $row[0];
                    while ($uid != null && $x != '4') {
                        if (get_user_roleID($uid) > '2') {
                            echo '<div class="flex-grow">
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    <a href="'.get_user_profile_link($uid).'" class="block relative">
                                        <img alt="'.get_user_fullname($uid).'" src="'.get_user_profilephoto($uid).'" class="mx-auto object-cover rounded-full h-10 w-10 "/>
                                    </a>
                                </div>
                                <a href="'.get_user_profile_link($uid).'" class="text-gray-600 dark:text-gray-400 text-xs mt-2">
                                    '.get_user_fullname($uid).'
                                </a>
                                <a href="'.get_user_profile_link($uid).'" class="mt-1 text-xs text-white bg-';
                            if (get_user_statistics_approvals($uid) == '0') {
                                echo 'red';
                            } elseif (get_user_statistics_approvals($uid) < '6') {
                                echo 'yellow';
                            } else {
                                echo 'green';
                            }
                            echo'-500 rounded-full p-1">
                                    '.$row[1].' Approvals
                                </a>
                            </div>
                        </div>';
                        }
                        $x++;
                        $row = mysqli_fetch_row($result);
                        if (isset($row[0])) {
                            $uid = $row[0];
                        }
                    }
                    echo '</div>
                </div>';
                } ?>
            </div>

            <?php display_dashboard_statistics($_SESSION['id']); ?>
        </div>
    </body>
</html>