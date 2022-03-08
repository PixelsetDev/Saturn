<?php
    $errorScreen = true;
    include_once $_SERVER['DOCUMENT_ROOT'].CONFIG_INSTALL_URL.'/common/global_public.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].CONFIG_INSTALL_URL.'/common/panel/vendors.php'; ?>
        <title><?php echo __('General:Error'); ?> 404 - <?php echo CONFIG_SITE_NAME; ?></title>
    </head>
    <body>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].CONFIG_INSTALL_URL.'/common/navigation.php'; ?>

        <main class="bg-white relative overflow-hidden h-screen relative">
            <div class="container mx-auto h-screen pt-32 md:pt-0 px-6 z-10 flex items-center justify-between">
                <div class="container mx-auto px-6 flex flex-col-reverse lg:flex-row justify-between items-center relative">
                    <div class="w-full mb-16 md:mb-8 text-center lg:text-left">
                        <h1 class="text-center lg:text-left text-5xl lg:text-8xl mt-12 md:mt-0 text-gray-700">
                            <?php echo __('Error:404_Message'); ?>
                        </h1>
                        <p class="text-base text-gray-700 mt-4">
                            <?php echo __('Error:404_Info'); ?>
                        </p>
                        <button onclick="location.href='/<?php echo CONFIG_INSTALL_URL; ?>';" class="px-2 py-2 w-36 mt-16 font-light transition ease-in duration-200 hover:bg-gray-200 border-2 text-lg border-gray-700 focus:outline-none">
                            <?php echo __('General:GoHome'); ?>
                        </button>
                    </div>
                    <div class="block w-full mx-auto md:mt-0 relative max-w-md lg:max-w-2xl">
                        <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/error.svg" alt="<?php echo __('General:Error'); ?>" />
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>