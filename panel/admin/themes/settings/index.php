<?php
session_start();
ob_start();
require_once __DIR__.'/../../../../common/global_private.php';
require_once __DIR__.'/../../../../common/admin/global.php';
ob_end_flush();
$slug = checkInput('DEFAULT', $_GET['slug']);
$themeDataJSON = file_get_contents(__DIR__.'/../../../../themes/'.$slug.'/theme.json');
$themeData = json_decode($themeDataJSON);

if (isset($_POST['update'])) {
    if (isset($_POST['theme_colour_scheme'])) {
        $theme_colour_scheme = checkInput('DEFAULT', $_POST['theme_colour_scheme']);
    } else {
        $theme_colour_scheme = THEME_COLOUR_SCHEME;
    }

    if (isset($_POST['theme_font'])) {
        $theme_font = checkInput('DEFAULT', $_POST['theme_font']);
    } else {
        $theme_font = THEME_COLOUR_SCHEME;
    }

    if (isset($_POST['panel_font'])) {
        $panel_font = checkInput('DEFAULT', $_POST['panel_font']);
    } else {
        $panel_font = THEME_PANEL_FONT;
    }

    if (isset($_POST['panel_colour_scheme'])) {
        $panel_colour_scheme = checkInput('DEFAULT', $_POST['panel_colour_scheme']);
    } else {
        $panel_colour_scheme = THEME_COLOUR_SCHEME;
    }

    $file = __DIR__.'/../../../../theme.php';

    $message = "<?php
    /* Website Theme */
    const THEME_SLUG = '".THEME_SLUG."';
    const THEME_COLOUR_SCHEME = '".$theme_colour_scheme."';
    const THEME_FONT = '".$theme_font."'; /* Google Font Name */
    /* Panel Theme */
    const THEME_PANEL_FONT = '".$panel_font."'; /* Google Font Name */
    const THEME_PANEL_COLOUR = '".$panel_colour_scheme."';
    /* Site Branding */
    const THEME_SOCIAL_IMAGE = CONFIG_INSTALL_URL.'/storage/images/social-image.jpg';";

    if (file_put_contents($file, $message, LOCK_EX) && ccv_reset()) {
        log_file('SATURN][SECURITY', get_user_fullname($_SESSION['id']).' '.__('Admin:Themes_UpdatedSettings_Message'));
        internal_redirect('/panel/admin/themes/settings/?slug='.$slug.'&successMsg='.__('Admin:Themes_UpdatedSettings'));
    } else {
        internal_redirect('/panel/admin/themes/settings/?slug='.$slug.'&errorMsg=Theme settings could not be updated.');
    }
    exit;
}
if (isset($_GET['activate'])) {
    $file = __DIR__.'/../../../../theme.php';

    $message = "<?php
    /* Website Theme */
    const THEME_SLUG = '".checkInput('DEFAULT', $_GET['slug'])."';
    const THEME_COLOUR_SCHEME = '".THEME_COLOUR_SCHEME."';
    const THEME_FONT = '".THEME_FONT."'; /* Google Font Name */
    /* Panel Theme */
    const THEME_PANEL_FONT = '".THEME_PANEL_FONT."'; /* Google Font Name */
    const THEME_PANEL_COLOUR = '".THEME_PANEL_COLOUR."';
    /* Site Branding */
    const THEME_SOCIAL_IMAGE = CONFIG_INSTALL_URL.'/storage/images/social-image.jpg';";

    if (file_put_contents($file, $message, LOCK_EX) && ccv_reset()) {
        log_file('SATURN][SECURITY', get_user_fullname($_SESSION['id']).' '.__('Admin:Themes_UpdatedSettings_Message'));
        internal_redirect('/panel/admin/themes/settings/?slug='.$slug.'&successMsg='.__('Admin:Themes_Activated'));
    } else {
        internal_redirect('/panel/admin/themes/settings/?slug='.$slug.'&errorMsg=Theme could not be activated.');
    }
    exit;
}

if (isset($_GET['uninstall_confirm'])) {
    if ($slug === $themeData->{'theme'}->{'slug'}) {
        if ($slug == THEME_SLUG) {
            $errorMsg = 'You can\'t uninstall an active theme.';
        } else {
            $dir = __DIR__.'/../../../../themes/'.$slug;
            if (is_dir($dir)) {
                array_map('unlink', glob("$dir/*.*"));
                if (rmdir($dir)) {
                    internal_redirect('/panel/admin/themes/settings/?slug='.$slug.'&successMsg='.__('Admin:Themes_Uninstalled'));
                } else {
                    internal_redirect('/panel/admin/themes/settings/?slug='.$slug.'&errorMsg=Unable to uninstall: The file or directory could not be deleted.');
                }
            } else {
                internal_redirect('/panel/admin/themes/settings/?slug='.$slug.'&errorMsg=Unable to uninstall: The file or directory could not be found.');
            }
        }
    } else {
        internal_redirect('/panel/admin/themes/settings/?slug='.$slug.'&errorMsg=Unable to uninstall: Invalid slug.');
    }
    exit;
}

if (isset($_GET['uninstall'])) {
    if ($slug == THEME_SLUG) {
        $errorMsg = 'You can\'t uninstall an active theme.';
    } else {
        $infoMsg = __('Admin:Themes_ConfirmUninstall');
    }
}

if (isset($_GET['errorMsg'])) {
    $errorMsg = checkInput('DEFAULT', $_GET['errorMsg']);
}
if (isset($_GET['successMsg'])) {
    $successMsg = checkInput('DEFAULT', $_GET['successMsg']);
}
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../../common/panel/vendors.php'; ?>

        <title><?php echo __('Admin:Themes_Settings'); ?> - <?php echo CONFIG_SITE_NAME.' '.__('Admin:Panel'); ?></title>
        <?php require __DIR__.'/../../../../common/panel/theme.php'; ?>

    </head>
    <body class="bg-<?php echo THEME_PANEL_COLOUR; ?>-200">
        <?php require __DIR__.'/../../../../common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-<?php echo THEME_PANEL_COLOUR; ?>-900 text-3xl"><?php echo __('Admin:Themes'); ?></h1>
            <?php
            if (isset($_GET['errorMsg'])) {
                $errorMsg = $_GET['errorMsg'];
                log_error('ERROR', checkInput('DEFAULT', $_GET['errorMsg']));
            }
            if (isset($_GET['successMsg'])) {
                $successMsg = $_GET['successMsg'];
            }
            if (isset($_GET['infoMsg'])) {
                $infoMsg = $_GET['infoMsg'];
            }

            if (isset($errorMsg)) {
                echo alert('ERROR', $errorMsg);
                log_error('ERROR', $errorMsg);
                unset($errorMsg);
            }
            if (isset($successMsg)) {
                echo alert('SUCCESS', $successMsg);
                unset($successMsg);
            }
            if (isset($infoMsg)) {
                echo alert('INFO', $infoMsg);
                unset($infoMsg);
            }
            ?>
            <br>
            <div class="flex">
                <h2 class="flex-grow text-<?php echo THEME_PANEL_COLOUR; ?>-900 text-2xl mt-8"><?php echo __('Admin:Themes_Settings'); ?>: <?php echo $themeData->{'theme'}->{'name'}; ?></h2>
                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/admin/themes" class="underline text-red-900 hover:text-red-800 text-2xl mt-8">Back</a>
            </div>
            <?php if (isset($themeData->{'theme'}->{'slug'})) { ?>
            <?php
            if ($themeData->{'theme'}->{'version'}->{'saturn'} != SATURN_VERSION) {
                echo alert('WARNING', __('Admin:Themes_NewVersion_For') . $themeData->{'theme'}->{'version'}->{'saturn'} . __('Admin:Themes_NewVersion_Running') . SATURN_VERSION . '".');
            }
            $remoteVersion = get_remote_marketplace_version($themeData->{'theme'}->{'slug'}, 'theme');
            if ($remoteVersion != $themeData->{'theme'}->{'version'}->{'theme'}) {
                if ($remoteVersion != "") {
                    echo alert('INFO', __('Admin:Themes_NewVersion_Message_1').' ' . $themeData->{'theme'}->{'version'}->{'theme'} . ' '.__('Admin:Themes_NewVersion_Message_2').' ' . $remoteVersion);
                } else {
                    echo alert('ERROR', 'Saturn is having issues connecting to the Marketplace server. If this issue persists please email contact@saturncms.net, thank you.');
                }
            }
            ?>
            <div class="grid grid-cols-2 mt-4">
                <div>
                    <h3 class="text-xl"><?php echo __('Admin:Themes_MakeActive'); ?></h3>
                    <?php if ($slug == THEME_SLUG) { ?>
                    <p><?php echo __('Admin:Themes_MakeActive_Already'); ?></p>
                    <?php } else { ?>
                    <a href="index.php?slug=<?php echo $slug; ?>&activate=true" class="underline"><?php echo __('Admin:Themes_MakeActive_Link'); ?></a>
                    <?php } ?>
                </div>
                <div>
                    <h3 class="text-xl"><?php echo __('Admin:Themes_AuthorInformation') ?></h3>
                    <p><?php echo __('General:Author') ?>: <?php echo $themeData->{'theme'}->{'author'}; ?></p>
                </div>
                <div class="mt-6">
                    <h3 class="text-xl"><?php echo __('Admin:Themes_Uninstall') ?></h3>
                    <?php if (isset($_GET['uninstall'])) { ?>
                        <?php if ($slug == THEME_SLUG) { ?>
                            <p><?php echo __('Error:Themes_Uninstall_Unable'); ?></p>
                        <?php } else { ?>
                            <a href="index.php?slug=<?php echo $slug; ?>&uninstall_confirm=true" class="underline"><?php echo __('General:Warning'); ?>: <?php echo __('General:CannotBeUndone'); ?> <?php echo __('General:AreYouSure'); ?> <?php echo __('General:ClickToConfirm'); ?></a>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($slug == THEME_SLUG) { ?>
                            <p><?php echo __('Error:Themes_Uninstall_Cant'); ?></p>
                        <?php } else { ?>
                            <a href="index.php?slug=<?php echo $slug; ?>&uninstall=true" class="underline"><?php echo __('Admin:Themes_Uninstall_Link'); ?></a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <?php if ($slug == THEME_SLUG) { ?>
            <div class="mt-6">
                <?php
                if ($themeData->{'theme'}->{'features'}->{'custom-fonts'} == "none") {
                    echo alert('WARNING', 'This theme does not support Website Fonts.').'<br>';
                }
                if (!isset($themeData->{'theme'}->{'features'})) {
                    echo alert('WARNING', 'This theme does not support advanced features. Please contact the theme author and ask them to enable this.').'<br>';
                }
                ?>
                <h3 class="text-xl"><?php echo __('Admin:Themes_Settings_General'); ?></h3>
                <form class="mt-4" action="" method="post">
                    <div class="grid grid-cols-2">
                        <label for="theme_colour_scheme"><?php echo __('Admin:Themes_Settings_Website_ColourScheme'); ?></label>
                        <select id="theme_colour_scheme" name="theme_colour_scheme" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-<?php echo THEME_PANEL_COLOUR; ?>-300 placeholder-<?php echo THEME_PANEL_COLOUR; ?>-500 text-<?php echo THEME_PANEL_COLOUR; ?>-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option disabled>-- <?php echo __('General:PleaseSelectOne'); ?> --</option>
                            <option value="light"<?php if (THEME_COLOUR_SCHEME == 'light') {
                echo ' selected';
            } ?>><?php echo __('General:Light'); ?></option>
                            <option value="dark"<?php if (THEME_COLOUR_SCHEME == 'dark') {
                echo ' selected';
            } ?>><?php echo __('General:Dark'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="theme_font"><?php echo __('Admin:Themes_Settings_Website_Font'); ?></label>
                        <input id="theme_font" name="theme_font" type="text" value="<?php echo THEME_FONT; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-<?php echo THEME_PANEL_COLOUR; ?>-300 placeholder-<?php echo THEME_PANEL_COLOUR; ?>-500 text-<?php echo THEME_PANEL_COLOUR; ?>-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm"<?php if($themeData->{'theme'}->{'features'}->{'custom-fonts'} == "none" || !isset($themeData->{'theme'}->{'features'})) { echo ' disabled'; } ?>>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="panel_colour_scheme"><?php echo __('Admin:Themes_Settings_Panel_ColourScheme'); ?></label>
                        <select id="panel_colour_scheme" name="panel_colour_scheme" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-<?php echo THEME_PANEL_COLOUR; ?>-300 placeholder-<?php echo THEME_PANEL_COLOUR; ?>-500 text-<?php echo THEME_PANEL_COLOUR; ?>-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                            <option disabled>-- <?php echo __('General:PleaseSelectOne'); ?> --</option>
                            <option value="gray"<?php if (THEME_PANEL_COLOUR == 'gray') {
                echo ' selected';
            } ?>><?php echo __('General:Gray'); ?></option>
                            <option value="red"<?php if (THEME_PANEL_COLOUR == 'red') {
                echo ' selected';
            } ?>><?php echo __('General:Red'); ?></option>
                            <option value="yellow"<?php if (THEME_PANEL_COLOUR == 'yellow') {
                echo ' selected';
            } ?>><?php echo __('General:Yellow'); ?></option>
                            <option value="green"<?php if (THEME_PANEL_COLOUR == 'green') {
                echo ' selected';
            } ?>><?php echo __('General:Green'); ?></option>
                            <option value="blue"<?php if (THEME_PANEL_COLOUR == 'blue') {
                echo ' selected';
            } ?>><?php echo __('General:Blue'); ?></option>
                            <option value="indigo"<?php if (THEME_PANEL_COLOUR == 'indigo') {
                echo ' selected';
            } ?>><?php echo __('General:Indigo'); ?></option>
                            <option value="purple"<?php if (THEME_PANEL_COLOUR == 'purple') {
                echo ' selected';
            } ?>><?php echo __('General:Purple'); ?></option>
                            <option value="pink"<?php if (THEME_PANEL_COLOUR == 'pink') {
                echo ' selected';
            } ?>><?php echo __('General:Pink'); ?></option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="panel_font"><?php echo __('Admin:Themes_Settings_Panel_Font'); ?></label>
                        <input id="panel_font" name="panel_font" type="text" value="<?php echo THEME_PANEL_FONT; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-<?php echo THEME_PANEL_COLOUR; ?>-300 placeholder-<?php echo THEME_PANEL_COLOUR; ?>-500 text-<?php echo THEME_PANEL_COLOUR; ?>-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                    </div>
                    <br>
                    <input type="submit" name="update" value="Save" class="hover:shadow-lg cursor-pointer group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200" control-id="ControlID-1">
                </form>
            </div>
            <?php } } else { ?>
            <div class="grid grid-cols-2 mt-4">
                <div>
                    <h3 class="text-xl">Theme not found.</h3>
                </div>
            </div>
            <?php }?>
        </div>
    </body>
</html>