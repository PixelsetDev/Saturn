<?php
session_start();
ob_start();
require_once __DIR__.'/../../../../assets/common/global_private.php';
require_once __DIR__.'/../../../../assets/common/admin/global.php';
ob_end_flush();
$slug = checkInput('DEFAULT', $_GET['slug']);
$themeDataJSON = file_get_contents(__DIR__.'/../../../../themes/'.$slug.'/theme.json');
$themeData = json_decode($themeDataJSON);

if (isset($_GET['activate'])) {
    $file = __DIR__.'/../../../../theme.php';

    $message = "<?php
    /* Website Theme */
    const THEME_SLUG = '".checkInput('DEFAULT', $_GET['slug'])."';
    const THEME_COLOUR_SCHEME = 'Light';
    const THEME_FONT = '".THEME_FONT."'; /* Google Font Name */
    /* Panel Theme */
    const THEME_PANEL_FONT = '".THEME_PANEL_FONT."'; /* Google Font Name */
    const THEME_PANEL_COLOUR = '".THEME_PANEL_COLOUR."';
    /* Site Branding */
    const THEME_SOCIAL_IMAGE = CONFIG_INSTALL_URL.'/assets/images/social-image.jpg';";

    if (file_put_contents($file, $message, LOCK_EX) && ccv_reset()) {
        log_file('SATURN][SECURITY', get_user_fullname($_SESSION['id']).' updated Website Settings.');
        $successMsg = 'Theme activated.';
    } else {
        $errorMsg = 'Theme could not be activated.';
    }
}
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../../assets/common/panel/vendors.php'; ?>

        <title>Theme Settings - <?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__.'/../../../../assets/common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../../assets/common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl">Themes</h1>
            <?php
            if (isset($errorMsg)) {
                echo alert('ERROR', $errorMsg);
                unset($errorMsg);
            }
            if (isset($successMsg)) {
                echo alert('SUCCESS', $successMsg);
                unset($successMsg);
            }
            ?>
            <br>
            <div class="flex">
                <h2 class="flex-grow text-gray-900 text-2xl mt-8">Theme Settings: <?php echo $themeData->{'theme'}->{'name'}; ?></h2>
                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/admin/themes" class="underline text-red-900 hover:text-red-800 text-2xl mt-8">Back</a>
            </div>
            <div class="grid grid-cols-2 mt-4">
                <div>
                    <h3 class="text-xl">Make Active Theme</h3>
                    <?php if ($slug == THEME_SLUG) { ?>
                    <p>This theme is already the active theme.</p>
                    <?php } else { ?>
                    <a href="index.php?slug=<?php echo $slug; ?>&activate=true" class="underline">Click here to make this the active theme.</a>
                    <?php } ?>
                </div>
                <div>
                    <h3 class="text-xl">Author Information</h3>
                    <p>Author: <?php echo $themeData->{'theme'}->{'author'}; ?></p>
                </div>
            </div>
        </div>
    </body>
</html>