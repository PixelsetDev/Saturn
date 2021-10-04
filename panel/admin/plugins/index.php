<?php
    session_start();
    ob_start();
    require_once __DIR__.'/../../../assets/common/global_private.php';
    require_once __DIR__.'/../../../assets/common/admin/global.php';
    if (isset($_GET['download'])) {
        if (marketplace_download_zip(checkInput('DEFAULT', $_GET['download']), '/../../../../plugins/download.zip')) {
            internal_redirect('/panel/admin/plugins?successMsg=The plugin was downloaded and installed successfully.');
        } else {
            internal_redirect('/panel/admin/plugins?errorMsg=An error occurred whilst downloading the plugin.');
        }
        exit;
    }
    ob_end_flush();
    if (isset($_GET['successMsg'])) {
        $successMsg = checkInput('DEFAULT', $_GET['successMsg']);
    }
    if (isset($_GET['errorMsg'])) {
        $errorMsg = checkInput('DEFAULT', $_GET['errorMsg']);
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../assets/common/panel/vendors.php'; ?>

        <title>Plugins - <?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__.'/../../../assets/common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../assets/common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl">Plugins</h1>
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
            <h2 class="text-gray-900 text-2xl mt-8">Installed Plugins</h2>
            <div class="my-6 flex space-x-3 p-3 bg-white rounded-t-md overflow-x-scroll">
                <?php
                    $pluginDirs = array_filter(glob(__DIR__.'/../../../plugins/*'), 'is_dir');
                    foreach ($pluginDirs as $pluginDir) {
                        $pluginDataJSON = file_get_contents($pluginDir.'/plugin.json');
                        $pluginData = json_decode($pluginDataJSON);

                        $pluginImage = $pluginData->{'plugin'}->{'image'};
                        if ($pluginImage == '') {
                            $pluginImage = CONFIG_INSTALL_URL.'/assets/images/no-image-500x500.png';
                        }

                        echo '<div class="overflow-hidden bg-gray-200 w-52 h-52 relative hover:shadow-xl transition duration-200 flex-shrink-0">
                                <div class="absolute bottom-0 w-full h-12 bg-black bg-opacity-50 overflow-x-auto z-20">
                                    <h3 class="text-lg mt-1 mx-2 text-white">'.$pluginData->{'plugin'}->{'name'}.'</h3>
                                    <p class="text-xs -mt-1 mb-1 mx-2 text-white">By '.$pluginData->{'plugin'}->{'author'}.'</p>
                                </div>
                                <div class="absolute top-0 right-0 p-1 bg-black bg-opacity-50 text-white z-20">
                                    '.$pluginData->{'plugin'}->{'version'}->{'plugin'}.'
                                </div>
                                <img class="h-full w-full object-cover transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 z-10" src="'.$pluginImage.'" alt="'.$pluginData->{'plugin'}->{'name'}.'">
                            </div>';
                    }
                ?>
            </div>
            <h2 class="text-gray-900 text-2xl mt-8">Plugin Marketplace</h2>
            <?php if (activation_validate()) { ?>
            <div class="my-6 flex space-x-3 p-3 bg-white rounded-t-md overflow-x-scroll w-full">
                <?php $pluginURL = 'https://www.marketplace.saturncms.net/plugins/embed'; echo file_get_contents($pluginURL); ?>
                <a href="https://marketplace.saturncms.net/plugins/?url=<?php echo url(); ?>" target="_blank">
                    <div class="overflow-hidden bg-gray-200 w-52 h-52 relative hover:shadow-xl transition duration-200 flex-shrink-0">
                        <div class="absolute bottom-0 w-full h-12 bg-black bg-opacity-50 overflow-x-auto z-20">
                            <h3 class="text-lg mt-1 mx-2 text-white">Get more Plugins</h3>
                            <p class="text-xs -mt-1 mb-1 mx-2 text-white">marketplace.saturncms.net</p>
                        </div>
                        <img class="h-full w-full object-cover transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 z-10" src="https://marketplace.saturncms.net/assets/images/sign.png" alt="Saturn Marketplace">
                    </div>
                </a>
            </div>
            <?php } else {
                    alert('ERROR', 'The Saturn Marketplace will not work if your installation is not activated.');
                } ?>
        </div>
    </body>
</html>