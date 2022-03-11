<?php
    session_start();
    ob_start();
    require_once __DIR__.'/../../../common/global_private.php';
    require_once __DIR__.'/../../../common/admin/global.php';
    if (isset($_GET['successMsg'])) {
        $successMsg = checkInput('DEFAULT', $_GET['successMsg']);
    }
    if (isset($_GET['errorMsg'])) {
        $errorMsg = checkInput('DEFAULT', $_GET['errorMsg']);
    }
    if (isset($_GET['download'])) {
        if (marketplace_download_zip(checkInput('DEFAULT', $_GET['download']), '/../../../themes/download.zip')) {
            internal_redirect('/panel/admin/themes?successMsg='.__('Admin:Themes_Installed_Success'));
        } else {
            internal_redirect('/panel/admin/themes?errorMsg=An error occurred whilst downloading the theme.');
        }
        exit;
    }
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../common/panel/vendors.php'; ?>

        <title><?php echo __('Admin:Themes'); ?> - <?php echo CONFIG_SITE_NAME.' '.__('Admin:Panel'); ?></title>
        <?php require __DIR__.'/../../../common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl"><?php echo __('Admin:Themes'); ?></h1>
            <?php
                if (isset($errorMsg)) {
                    echo alert('ERROR', $errorMsg);
                    log_error('ERROR', $errorMsg);
                    unset($errorMsg);
                }
                if (isset($successMsg)) {
                    echo alert('SUCCESS', $successMsg);
                    unset($successMsg);
                }
                if (isset($warningMsg)) {
                    echo alert('WARNING', $warningMsg);
                    unset($warningMsg);
                }
                if (isset($_GET['uploadedTo'])) {
                    echo alert('INFO', __('Admin:FileManager_Updated_1').'<br>'.__('Admin:FileManager_Updated_2'));
                }
            ?>
            <br>
            <h2 class="text-gray-900 text-2xl mt-8"><?php echo __('Admin:Themes_Installed'); ?></h2>
            <div class="my-6 flex space-x-3 p-3 bg-white rounded-t-md overflow-x-scroll">
                <?php
                $themeDirs = array_filter(glob(__DIR__.'/../../../themes/*'), 'is_dir');
                foreach ($themeDirs as $themeDir) {
                    $themeDataJSON = file_get_contents($themeDir.'/theme.json');
                    $themeData = json_decode($themeDataJSON);

                    $themeImage = $themeData->{'theme'}->{'image'};
                    if ($themeImage == '') {
                        $themeImage = CONFIG_INSTALL_URL.'/storage/images/no-image-500x500.png';
                    }

                    $themeFramework = $themeData->{'theme'}->{'framework'};
                    if ($themeFramework == '') {
                        $themeFramework = 'question_mark';
                    } ?>
                <a href="settings?slug=<?php echo $themeData->{'theme'}->{'slug'}; ?>" class="overflow-hidden bg-gray-200 w-52 h-52 relative hover:shadow-xl transition duration-200 flex-shrink-0 rounded">
                    <div class="absolute bottom-0 w-full h-12 bg-black bg-opacity-50 overflow-x-auto z-20 flex">
                        <div class="flex-grow">
                            <h3 class="text-lg mt-1 mx-2 text-white"><?php echo $themeData->{'theme'}->{'name'}; ?></h3>
                            <p class="text-xs -mt-1 mb-1 mx-2 text-white"><?php echo __('General:By'); ?> <?php echo $themeData->{'theme'}->{'author'}; ?></p>
                        </div>
                        <?php
                            $remoteVersion = get_remote_marketplace_version($themeData->{'theme'}->{'slug'}, 'theme');
                            if ($themeData->{'theme'}->{'slug'} == THEME_SLUG) {
                        ?>
                        <p class="text-xs text-white">ACTIVE</p>
                        <?php } ?>
                    </div>
                    <?php if (($remoteVersion != $themeData->{'theme'}->{'version'}->{'theme'}) && ($remoteVersion != "")) { ?>
                    <div class="absolute top-1/3 left-1/3 text-white z-20">
                        <i class="fas fa-sync fa-4x"></i>
                    </div>
                    <?php } ?>
                    <div class="absolute top-0 left p-1 bg-black bg-opacity-50 text-white z-20">
                        <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/icons/<?php echo $themeFramework; ?>.svg" class="w-6 h-6" alt="<?php echo $themeFramework; ?>">
                    </div>
                    <div class="absolute top-0 right-0 p-1 bg-black bg-opacity-50 <?php if ($remoteVersion != $themeData->{'theme'}->{'version'}->{'theme'} && $remoteVersion != "") { ?>text-red-500<?php } else { ?>text-white<?php } ?> z-20">
                        <?php echo $themeData->{'theme'}->{'version'}->{'theme'}; ?>
                    </div>
                    <img class="h-full w-full object-cover transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 z-10" src="<?php echo $themeImage; ?>" alt="<?php echo $themeData->{'theme'}->{'name'}; ?>">
                </a>
                <?php
                }?>
            </div>
            <h2 class="text-gray-900 text-2xl mt-8"><?php echo __('Admin:Themes_Marketplace'); ?></h2>
            <?php if (activation_validate()) { ?>
            <div class="my-6 flex space-x-3 p-3 bg-white rounded-t-md overflow-x-scroll">
                <?php $themeURL = 'https://www.marketplace.saturncms.net/themes/embed'; echo file_get_contents($themeURL); ?>
                <a href="https://marketplace.saturncms.net/themes/?url=<?php echo url(); ?>" target="_blank">
                    <div class="overflow-hidden bg-gray-200 w-52 h-52 relative hover:shadow-xl transition duration-200 flex-shrink-0 rounded">
                        <div class="absolute bottom-0 w-full h-12 bg-black bg-opacity-50 overflow-x-auto z-20">
                            <h3 class="text-lg mt-1 mx-2 text-white"><?php echo __('Admin:Themes_GetMore'); ?></h3>
                            <p class="text-xs -mt-1 mb-1 mx-2 text-white">marketplace.saturncms.net</p>
                        </div>
                        <img class="h-full w-full object-cover transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 z-10" src="https://marketplace.saturncms.net/assets/images/sign.png" alt="Saturn Marketplace">
                    </div>
                </a>
            </div>
            <?php } else {
                    echo alert('WARNING', 'The Saturn Marketplace will not work if your installation is not activated.');
                } ?>
            <h2 class="text-gray-900 text-2xl mt-8"><?php echo __('Admin:Themes_Assets'); ?></h2>
            <div class="flex my-6 space-x-4">
                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/files/upload/?type=image&uploadTo=/storage/images/&renameTo=icon.png&redirectTo=<?php echo CONFIG_INSTALL_URL; ?>/panel/admin/themes&maxHeight=400&maxWidth=400" class="md:w-1/6 w-1/3 p-4 relative overflow-hidden rounded-md bg-white shadow hover:shadow-xl transition duration-200">
                    <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/icon.png?id=<?php echo rand(0000, 9999); ?>" class="self-center" alt="Icon (PNG)">
                    <p class="p-1 bg-gray-100 text-gray-900 absolute bottom-0 left-0 rounded-md bg-opacity-50"><?php echo __('Admin:Themes_Icon'); ?> (PNG)</p>
                </a>
                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/files/upload/?type=image&uploadTo=/storage/images/&renameTo=logo.png&redirectTo=<?php echo CONFIG_INSTALL_URL; ?>/panel/admin/themes&maxHeight=200&maxWidth=1000" class="md:w-1/6 w-1/3 p-4 relative overflow-hidden rounded-md bg-white shadow hover:shadow-xl transition duration-200">
                    <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/logo.png?id=<?php echo rand(0000, 9999); ?>" class="self-center" alt="Logo (PNG)">
                    <p class="p-1 bg-gray-100 text-gray-900 absolute bottom-0 left-0 rounded-md bg-opacity-50"><?php echo __('Admin:Themes_Logo'); ?> (PNG)</p>
                </a>
                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/files/upload/?type=image&uploadTo=/storage/images/&renameTo=defaultprofile.png&redirectTo=<?php echo CONFIG_INSTALL_URL; ?>/panel/admin/themes&maxHeight=400&maxWidth=400" class="md:w-1/6 w-1/3 p-4 relative overflow-hidden rounded-md bg-white shadow hover:shadow-xl transition duration-200">
                    <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/defaultprofile.png?id=<?php echo rand(0000, 9999); ?>" class="self-center" alt="Default Profile Picture (PNG)">
                    <p class="p-1 bg-gray-100 text-gray-900 absolute bottom-0 left-0 rounded-md bg-opacity-50"><?php echo __('Admin:Themes_DefaultProfile'); ?> (PNG)</p>
                </a>
                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/files/upload/?type=image&uploadTo=/storage/images/&renameTo=no-image-500x500.png&redirectTo=<?php echo CONFIG_INSTALL_URL; ?>/panel/admin/themes&maxHeight=400&maxWidth=400" class="md:w-1/6 w-1/3 p-4 relative overflow-hidden rounded-md bg-white shadow hover:shadow-xl transition duration-200">
                    <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/no-image-500x500.png?id=<?php echo rand(0000, 9999); ?>" class="self-center" alt="'Missing Image' Image (PNG)">
                    <p class="p-1 bg-gray-100 text-gray-900 absolute bottom-0 left-0 rounded-md bg-opacity-50"><?php echo __('Admin:Themes_MissingImage'); ?> (PNG)</p>
                </a>
                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/files/upload/?type=image&uploadTo=/storage/images/&renameTo=error.svg&redirectTo=<?php echo CONFIG_INSTALL_URL; ?>/panel/admin/themes&maxHeight=400&maxWidth=400" class="md:w-1/6 w-1/3 p-4 relative overflow-hidden rounded-md bg-white shadow hover:shadow-xl transition duration-200">
                    <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/error.svg?id=<?php echo rand(0000, 9999); ?>" class="self-center" alt="Error Image (SVG)">
                    <p class="p-1 bg-gray-100 text-gray-900 absolute bottom-0 left-0 rounded-md bg-opacity-50"><?php echo __('Admin:Themes_ErrorImage'); ?> (SVG)</p>
                </a>
            </div>
        </div>
    </body>
</html>