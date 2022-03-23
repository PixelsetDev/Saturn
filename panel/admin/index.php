<?php
    session_start();
    ob_start();
    require_once __DIR__.'/../../common/global_private.php';
    require_once __DIR__.'/../../common/admin/global.php';
    ob_end_flush();

    if (((isset($_GET['update']) || CONFIG_UPDATE_AUTO) && CONFIG_UPDATE_CHECK) && latest_version() != SATURN_VERSION) {
        $downloadUrl = 'https://link.saturncms.net/update/'.latest_version().'.zip';
        $downloadTo = 'update.zip';
        if (strpos($downloadUrl, 'saturncms.net') !== false) {
            $installFile = __DIR__.'/../../'.$downloadTo;
            echo $installFile;
            file_put_contents($installFile, fopen($downloadUrl, 'r'));
            $path = pathinfo(realpath($installFile), PATHINFO_DIRNAME);
            $archive = new ZipArchive();
            $res = $archive->open($installFile);
            if ($res) {
                $archive->extractTo($path);
                $archive->close();
                if (!unlink($installFile)) {
                    $complete = false;
                    $errorMsg = __('Error:Update_DeleteFile');
                } else {
                    $complete = true;
                }
            } else {
                $complete = false;
                $errorMsg = __('Error:Update_UnzipArchive');
            }
        } else {
            $complete = false;
            $errorMsg = __('Error:Update_UntrustedURL').' '.$downloadUrl;
        }

        if ($complete) {
            header('Location: /update.php');
            exit;
        }
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../common/panel/vendors.php'; ?>

        <title><?php echo CONFIG_SITE_NAME.' '.__('Admin:Panel'); ?></title>
        <?php require __DIR__.'/../../common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../common/admin/navigation.php'; ?>

            <div class="px-8 py-4 w-full">
                <?php
                    if (isset($_GET['error'])) {
                        $error = checkInput('DEFAULT', $_GET['error']);
                        log_error('ERROR', $error);
                        echo alert('ERROR', $error).'<br>';
                    }
                    if (isset($errorMsg)) {
                        $error = checkInput('DEFAULT', $errorMsg);
                        log_error('ERROR', $error);
                        echo alert('ERROR', $error).'<br>';
                    }
                    if (isset($success)) {
                        $success = checkInput('DEFAULT', $success);
                        echo alert('SUCCESS', $success).'<br>';
                    }
                ?>

                <h1 class="text-gray-900 text-3xl"><?php echo __('Admin:Panel'); ?></h1>
                <br>
                <div class="flex w-full">
                    <div class="w-full mr-1 my-1 duration-300 transform bg-<?php echo THEME_PANEL_COLOUR; ?>-100 border-l-4 border-<?php echo THEME_PANEL_COLOUR; ?>-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5 text-<?php echo THEME_PANEL_COLOUR; ?>-700">
                                <?php
                                $result = mysqli_query($conn, 'SELECT `id` FROM `'.DATABASE_PREFIX.'pages` WHERE 1;');
                                $rows = mysqli_num_rows($result);
                                echo $rows;
                                unset($result, $rows);
                                ?> <?php echo __('Panel:Pages'); ?>.
                            </h6>
                            <p class="mb-2 leading-5 text-<?php echo THEME_PANEL_COLOUR; ?>-700">
                                <?php
                                $result = mysqli_query($conn, 'SELECT `content` FROM `'.DATABASE_PREFIX.'pages_pending` WHERE `content` IS NOT NULL;');
                                $rows = mysqli_num_rows($result);
                                echo $rows;
                                unset($result, $rows);
                                ?> <?php echo __('Admin:PendingApproval'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="w-full mr-1 my-1 duration-300 transform bg-<?php echo THEME_PANEL_COLOUR; ?>-100 border-l-4 border-<?php echo THEME_PANEL_COLOUR; ?>-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5 text-<?php echo THEME_PANEL_COLOUR; ?>-700">
                                <?php
                                $result = mysqli_query($conn, 'SELECT `content` FROM `'.DATABASE_PREFIX.'articles` WHERE 1;');
                                $rows = mysqli_num_rows($result);
                                echo $rows;
                                unset($result, $rows);
                                ?> <?php echo __('Panel:Articles'); ?>
                            </h6>
                            <p class="mb-2 leading-5 text-<?php echo THEME_PANEL_COLOUR; ?>-700">
                                <?php
                                $result = mysqli_query($conn, 'SELECT `status` FROM `'.DATABASE_PREFIX."articles` WHERE `status` = 'PENDING';");
                                $rows = mysqli_num_rows($result);
                                echo $rows;
                                unset($result, $rows);
                                ?> <?php echo __('Admin:PendingPublication'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex w-full">
                    <?php
                        $sql = 'SELECT `id` from `'.DATABASE_PREFIX.'users` WHERE 1';
                        $results = mysqli_query($conn, $sql);
                        $rows = mysqli_num_rows($results);
                        $sql = 'SELECT `id` from `'.DATABASE_PREFIX."users` WHERE `role_id` NOT IN ('0', '1');";
                        $results = mysqli_query($conn, $sql);
                        $activerows = mysqli_num_rows($results);
                        if ($activerows != 0) {
                            $colour = 'green';
                        } else {
                            $colour = 'red';
                        }
                        $sql = 'SELECT `id` from `'.DATABASE_PREFIX."users` WHERE `role_id` = '1';";
                        $results = mysqli_query($conn, $sql);
                        $pendingrows = mysqli_num_rows($results);
                        if ($pendingrows != 0) {
                            $colour = 'yellow';
                        }
                        $sql = 'SELECT `id` from `'.DATABASE_PREFIX."users` WHERE `role_id` = '0';";
                        $results = mysqli_query($conn, $sql);
                        $bannedrows = mysqli_num_rows($results);
                    ?>
                    <div class="w-full mr-1 my-1 duration-300 transform bg-<?php echo $colour; ?>-100 border-l-4 border-<?php echo $colour; unset($colour); ?>-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5"><?php echo $rows.' '.__('Admin:RegisteredUsers'); ?></h6>
                            <p><?php echo $activerows; ?> <?php echo __('Admin:AuthorisedUsers'); ?></p>
                            <p><em><?php echo $pendingrows; ?> <?php echo __('Admin:PendingUsers'); ?></em></p>
                            <p><em><?php echo $bannedrows; ?> <?php echo __('Admin:RestrictedUsers'); ?></em></p>
                        </div>
                    </div>
                    <?php
                    $phpversion = phpversion(); $badServer = 0;
                    if ($phpversion < '7.4.0' || $phpversion > '8') {
                        $badServer++;
                    }
                    if (PHP_OS != 'Linux') {
                        $badServer++;
                    }

                    if ($badServer == 1) {
                        echo '<div class="w-full mr-1 my-1 duration-300 transform bg-yellow-100 border-l-4 border-yellow-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">'.__('Admin:ConfigChanges_Title').'</h6>
                            '.__('Admin:ConfigChanges_Message_General').'
                        </div>
                    </div>';
                    } elseif ($badServer == 2) {
                        echo '<div class="w-full mr-1 my-1 duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">'.__('Admin:ConfigChanges_Title').'</h6>
                            '.__('Admin:ConfigChanges_Message_Version').'
                        </div>
                    </div>';
                    }
                    ?>
                    <?php if (latest_version() != SATURN_VERSION && CONFIG_UPDATE_CHECK) {
                        echo '
                    <div class="w-full mr-1 my-1 duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">'.__('Admin:UpdateAvailable').'</h6>
                            '.__('Admin:UpdateAvailable_Message').'<br>
                            <a href="?update=true" class="underline">'.__('Admin:UpdateAvailable_Button').'</a>
                        </div>
                    </div>';
                    } ?>
                </div>
                <br>
                <?php
                $activation_key = file_get_contents('https://link.saturncms.net/?key_status='.CONFIG_ACTIVATION_KEY);
                $activation_key_url = file_get_contents('https://link.saturncms.net/?key_registered_url='.CONFIG_ACTIVATION_KEY);
                ?>
                <div class="md:flex">
                    <div class="md:flex-grow">
                        <div class="flex">
                            <h2 class="flex space-x-2 text-gray-900 text-2xl relative" x-data="{ tooltip: false }">
                                <span><?php echo __('Admin:Activation'); ?></span>
                                <?php if ($activation_key == '1' && $activation_key_url == $_SERVER['HTTP_HOST']) { ?>
                                <i class="fas fa-check text-green-500" aria-hidden="true" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false"></i>
                                <div class="mx-1 w-18" x-cloak x-show.transition.origin.top="tooltip">
                                    <div class="bg-black text-white text-xs rounded py-1 px-2 right-0 bottom-full opacity-75">
                                        <?php echo __('Admin:Activated'); ?>
                                    </div>
                                </div>
                                <?php } else { ?>
                                <i class="fas fa-times text-red-500" aria-hidden="true" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false"></i>
                                <div class="mx-1 w-22" x-cloak x-show.transition.origin.top="tooltip">
                                    <div class="bg-black text-white text-xs rounded py-1 px-2 right-0 bottom-full opacity-75">
                                        <?php echo __('Admin:NotActivated'); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            </h2>
                        </div>
                        <p>
                            <?php
                            if ($activation_key == '1') {
                                echo '<u>'.__('Admin:Settings_ActivationKey').'</u>: '.CONFIG_ACTIVATION_KEY.' <small class="text-green-500">'.__('Admin:Settings_ActivationKey').'</small>';
                            } else {
                                echo '<u>'.__('Admin:Settings_ActivationKey').'</u>: '.CONFIG_ACTIVATION_KEY.' <small class="text-red-500">'.__('Admin:Invalid').'</small>';
                            }
                            ?>
                            <br>
                            <?php
                            if ($activation_key_url == $_SERVER['HTTP_HOST']) {
                                echo '<u>'.__('Admin:InstalledURL').'</u>: '.$_SERVER['HTTP_HOST'].' <small class="text-green-500">'.__('Admin:Valid').'</small>';
                            } else {
                                if (strpos($activation_key_url, 'Activation Error') !== false) {
                                    $activation_key_url = 'No URL Found';
                                }
                                echo '<u>'.__('Admin:InstalledURL').'</u>: '.$_SERVER['HTTP_HOST'].' <small class="text-red-500">'.__('Admin:Invalid').' ('.__('Admin:RegisteredTo').' '.$activation_key_url.')</small>';
                            }
                            ?>
                        </p>
                        <br>
                        <h2 class="text-gray-900 text-2xl">Your Server</h2>
                        <p>
                            <?php
                                if ($phpversion < '7.4.0' || $phpversion > '8') {
                                    echo '<u>'.__('Admin:PHPVersion').'</u> <span class="text-red-500">'.$phpversion.'</span> <small class="text-red-900">'.__('Admin:PHPVersion_Recommended').'</small>';
                                } else {
                                    echo '<u>'.__('Admin:PHPVersion').'</u> <span class="text-green-500">'.$phpversion.'</span>';
                                }
                                if (PHP_OS != 'Linux') {
                                    echo '<br><u>'.__('Admin:OperatingSystem').'</u> <span class="text-red-500">'.PHP_OS.'</span> <small class="text-red-900">'.__('Admin:Operating_Recommended').'</small>';
                                } else {
                                    echo '<br><u>'.__('Admin:OperatingSystem').'</u> <span class="text-green-500">'.PHP_OS.'</span>';
                                }
                            ?>
                        </p>
                        <br>
                        <h2 class="text-gray-900 text-2xl">System Updates</h2>
                        <p>
                            <u>Latest Version:</u> <?php echo latest_version(); ?><br>
                            <u>Current Version:</u> <?php echo SATURN_VERSION; ?><br>
                            <u>Branch:</u> <?php echo SATURN_BRANCH; ?><br>
                            <?php if (!CONFIG_UPDATE_CHECK) { ?><p class="italic text-xs"><?php echo __('Admin:UpdateCheckingDisabled'); ?></p><?php } ?>
                            <?php if (!CONFIG_UPDATE_AUTO) { ?><p class="italic text-xs"><?php echo __('Admin:AutoUpdateDisabled'); ?></p><?php } ?>
                            <?php if (latest_version() != SATURN_VERSION && CONFIG_UPDATE_CHECK) { ?>
                            <p class="italic underline"><a href="?update=true"><?php echo __('Admin:UpdateAvailable_Button'); ?></a></p>
                            <?php } else { ?>
                            <p class="italic"><?php echo __('Admin:LatestVersion'); ?></p>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="md:h-screen h-auto md:w-1/3">
                        <br class="md:hidden block">
                        <h2 class="text-gray-900 text-2xl px-2"><?php echo __('Admin:News'); ?></h2>
                        <iframe src="https://link.saturncms.net/news?embedded=true" class="h-1/2 border border-black rounded-md shadow-lg" title="<?php echo __('Admin:News'); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>