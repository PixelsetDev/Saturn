<?php
    session_start();
    require_once __DIR__.'/../../assets/common/global_private.php';
    $remoteVersion = file_get_contents('https://link.saturncms.net/?latest_version=beta');
    $localVersion = file_get_contents(__DIR__.'/../../assets/common/version.txt');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__ . '/../../assets/common/panel/vendors.php'; ?>

        <title><?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__.'/../../assets/common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../assets/common/admin/navigation.php'; ?>

            <div class="px-8 py-4 w-full">
                <?php
                    if(isset($_GET['error'])) {
                        $error = checkInput('DEFAULT',$_GET['error']);
                        alert('ERROR', $error);
                    }
                ?>

                <h1 class="text-gray-900 text-3xl">Admin Panel</h1>
                <br>
                <div class="flex w-full">
                    <div class="w-full mr-1 my-1 duration-300 transform bg-<?php echo THEME_PANEL_COLOUR; ?>-100 border-l-4 border-<?php echo THEME_PANEL_COLOUR; ?>-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5 text-<?php echo THEME_PANEL_COLOUR; ?>-700">
                                <?php
                                $result = mysqli_query($conn,"SELECT `id` FROM `".DATABASE_PREFIX."pages` WHERE 1;");
                                $rows = mysqli_num_rows($result);
                                echo $rows;
                                unset($result, $rows);
                                ?> pages.
                            </h6>
                            <p class="mb-2 leading-5 text-<?php echo THEME_PANEL_COLOUR; ?>-700">
                                <?php
                                $result = mysqli_query($conn,"SELECT `content` FROM `".DATABASE_PREFIX."pages_pending` WHERE `content` IS NOT NULL;");
                                $rows = mysqli_num_rows($result);
                                echo $rows;
                                unset($result, $rows);
                                ?> pending approval.
                            </p>
                        </div>
                    </div>
                    <div class="w-full mr-1 my-1 duration-300 transform bg-<?php echo THEME_PANEL_COLOUR; ?>-100 border-l-4 border-<?php echo THEME_PANEL_COLOUR; ?>-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5 text-<?php echo THEME_PANEL_COLOUR; ?>-700">
                                <?php
                                $result = mysqli_query($conn,"SELECT `content` FROM `".DATABASE_PREFIX."articles` WHERE 1;");
                                $rows = mysqli_num_rows($result);
                                echo $rows;
                                unset($result, $rows);
                                ?> articles.
                            </h6>
                            <p class="mb-2 leading-5 text-<?php echo THEME_PANEL_COLOUR; ?>-700">
                                <?php
                                $result = mysqli_query($conn,"SELECT `content` FROM `".DATABASE_PREFIX."articles` WHERE `content` IS NOT NULL;");
                                $rows = mysqli_num_rows($result);
                                echo $rows;
                                unset($result, $rows);
                                ?> pending publication.
                            </p>
                        </div>
                    </div>
                    <div class="w-full mr-1 my-1 duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">Unable to fetch interactive information.</h6>
                        </div>
                    </div>
                </div>
                <div class="flex w-full">
                    <?php
                        $sql = "SELECT `id` from `gh_users` WHERE 1";
                        $results = mysqli_query($conn,$sql);
                        $rows = mysqli_num_rows($results);
                        $sql = "SELECT `id` from `gh_users` WHERE `role_id` NOT IN ('0', '1');";
                        $results = mysqli_query($conn,$sql);
                        $activerows = mysqli_num_rows($results);
                        if ($activerows != 0) {$colour = 'green';} else {$colour = 'red';}
                        $sql = "SELECT `id` from `gh_users` WHERE `role_id` = '1';";
                        $results = mysqli_query($conn,$sql);
                        $pendingrows = mysqli_num_rows($results);
                        if ($pendingrows != 0) {$colour = 'yellow';}
                        $sql = "SELECT `id` from `gh_users` WHERE `role_id` = '0';";
                        $results = mysqli_query($conn,$sql);
                        $bannedrows = mysqli_num_rows($results);
                    ?>
                    <div class="w-full mr-1 my-1 duration-300 transform bg-<?php echo $colour; ?>-100 border-l-4 border-<?php echo $colour; unset($colour); ?>-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5"><?php echo $rows; ?> users.</h6>
                            <p><?php echo $activerows; ?> authorised users.</p>
                            <p><em><?php echo $pendingrows; ?> pending users.</em></p>
                            <p><em><?php echo $bannedrows; ?> restricted users.</em></p>
                        </div>
                    </div>
                    <?php $phpversion = phpversion(); $badServer=0; if ($phpversion < '7.4.0' OR $phpversion > '8') {$badServer++;} if (PHP_OS != 'Linux') {$badServer++;}
                    if ($badServer == 1) {
                        echo '<div class="w-full mr-1 my-1 duration-300 transform bg-yellow-100 border-l-4 border-yellow-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">We recommend configuration changes to your server.</h6>
                            Please see the \'My Server\' section below.
                        </div>
                    </div>';
                    } else if ($badServer == 2) {
                        echo '<div class="w-full mr-1 my-1 duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">We recommend configuration changes to your server.</h6>
                            PHP Version not Supported and OS Not Recommended.
                        </div>
                    </div>';
                    }
                    ?>
                    <?php if ($remoteVersion != $localVersion) {
                        echo '
                    <div class="w-full mr-1 my-1 duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">An update is available.</h6>
                            Please see the \'System Updates\' section below.
                        </div>
                    </div>';
                    } ?>
                </div>
                <br>
                <h2 class="text-gray-900 text-2xl">Your Server</h2>
                <p>
                    <?php
                        if ($phpversion < '7.4.0' OR $phpversion > '8') {echo '<u>PHP Version</u>: <span class="text-red-500">'.$phpversion.'</span> <small class="text-red-900">Recommended: 7.4.0</small>';} else {echo '<u>PHP Version</u>: <span class="text-green-500">'.$phpversion.'</span>';}
                        if (PHP_OS != 'Linux') {echo '<br><u>Operating System</u>: <span class="text-red-500">'.PHP_OS.'</span> <small class="text-red-900">Recommended: Linux</small>';} else {echo '<br><u>Operating System</u>: <span class="text-green-500">'.PHP_OS.'</span>';}
                    ?>
                </p>
                <br>
                <h2 class="text-gray-900 text-2xl">System Updates</h2>
                <p>
                    <u>Latest Version:</u> <?php echo $remoteVersion; ?><br>
                    <u>Current Version:</u> <?php echo $localVersion; ?><br>
                </p>
            </div>
        </div>
    </body>
</html>