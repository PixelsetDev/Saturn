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

        <title><?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
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
            <div class="my-6 flex space-x-6">
                <?php
                    $dirs = array_filter(glob(__DIR__.'/../../../themes/*'), 'is_dir');
                    foreach ($dirs as $dir) {
                        $json =  file_get_contents($dir.'/theme.json');
                        $themeData = json_decode($json);

                        $image = $themeData->{'theme'}->{'image'};
                        if ($image == "") {
                            $image = CONFIG_INSTALL_URL.'/assets/images/no-image-500x500.png';
                        }

                        echo '<div class="bg-white w-52 h-52 relative shadow-lg hover:shadow-2xl transition duration-200">
                            <div class="absolute bottom-0 w-full h-12 bg-black bg-opacity-50 overflow-x-auto">
                                <h3 class="text-lg my-2 mx-2 text-white">'.$themeData->{'theme'}->{'name'}.'</h3>
                            </div>
                            <div class="absolute top-0 left rounded-br-md p-1 bg-black bg-opacity-50 text-white">
                                <img src="'.CONFIG_INSTALL_URL.'/assets/images/icons/'.$themeData->{'theme'}->{'framework'}.'.svg" class="w-6 h-6">
                            </div>
                            <div class="absolute top-0 right-0 rounded-bl-md p-1 bg-black bg-opacity-50 text-white">
                                '.$themeData->{'theme'}->{'version'}.'
                            </div>
                            <img class="w-full h-full" src="'.$image.'">
                        </div>';
                    }
                ?>
            </div>
        </div>
    </body>
</html>