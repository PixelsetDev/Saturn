<?php
    session_start();
    ob_start();
    require_once __DIR__ . '/../../../assets/common/global_private.php';
    require_once __DIR__ . '/../../../assets/common/processes/gui/modals.php';

    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__ . '/../../../assets/common/panel/vendors.php'; ?>

        <title>Themes - <?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__ . '/../../../assets/common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__ . '/../../../assets/common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl">Themes</h1>
            <?php
                if(isset($errorMsg)){
                    alert('ERROR', $errorMsg);
                    unset($errorMsg);
                }
                if(isset($successMsg)){
                    alert('SUCCESS', $successMsg);
                    unset($successMsg);
                }
            ?>
            <br>
            <h2 class="text-gray-900 text-2xl mt-8">Installed Themes</h2>
            <div class="my-6 flex space-x-3 p-3 bg-white rounded-t-md overflow-x-scroll">
                <?php
                    $dirs = array_filter(glob(__DIR__.'/../../../themes/*'), 'is_dir');
                    foreach ($dirs as $dir) {
                        $json =  file_get_contents($dir.'/theme.json');
                        $themeData = json_decode($json);

                        $image = $themeData->{'theme'}->{'image'};
                        if ($image == "") {
                            $image = CONFIG_INSTALL_URL.'/assets/images/no-image-500x500.png';
                        }

                        $framework = $themeData->{'theme'}->{'framework'};
                        if ($framework == "") {
                            $framework = 'question_mark';
                        }

                        echo '<div class="overflow-hidden bg-gray-200 w-52 h-52 relative hover:shadow-xl transition duration-200 flex-shrink-0">
                            <div class="absolute bottom-0 w-full h-12 bg-black bg-opacity-50 overflow-x-auto z-20">
                                <h3 class="text-lg mt-1 mx-2 text-white">'.$themeData->{'theme'}->{'name'}.'</h3>
                                <p class="text-xs -mt-1 mb-1 mx-2 text-white">By '.$themeData->{'theme'}->{'author'}.'</p>
                            </div>
                            <div class="absolute top-0 left p-1 bg-black bg-opacity-50 text-white z-20">
                                <img src="'.CONFIG_INSTALL_URL.'/assets/images/icons/'.$framework.'.svg" class="w-6 h-6" alt="'.$framework.'">
                            </div>
                            <div class="absolute top-0 right-0 p-1 bg-black bg-opacity-50 text-white z-20">
                                '.$themeData->{'theme'}->{'version'}->{'theme'}.'
                            </div>
                            <img class="h-full w-full object-cover transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 z-10" src="'.$image.'" alt="'.$themeData->{'theme'}->{'name'}.'">
                        </div>';
                    }
                ?>
            </div>
            <h2 class="text-gray-900 text-2xl mt-8">Theme Marketplace</h2>
            <div class="my-6 flex space-x-3 p-3 bg-white rounded-t-md overflow-x-scroll">
                <?php echo file_get_contents('https://www.marketplace.saturncms.net/themes/embed'); ?>
                <a href="https://marketplace.saturncms.net/themes/?url=<?php echo url(); ?>" target="_blank">
                    <div class="overflow-hidden bg-gray-200 w-52 h-52 relative hover:shadow-xl transition duration-200 flex-shrink-0">
                        <div class="absolute bottom-0 w-full h-12 bg-black bg-opacity-50 overflow-x-auto z-20">
                            <h3 class="text-lg mt-1 mx-2 text-white">Get more Themes</h3>
                            <p class="text-xs -mt-1 mb-1 mx-2 text-white">marketplace.saturncms.net</p>
                        </div>
                        <img class="h-full w-full object-cover transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 z-10" src="https://marketplace.saturncms.net/assets/images/sign.png" alt="Saturn Marketplace">
                    </div>
                </a>
            </div>
        </div>
    </body>
</html>