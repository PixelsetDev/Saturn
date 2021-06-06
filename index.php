<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once(__DIR__.'/assets/common/global_public.php');
        ?>
        <title><?php echo CONFIG_SITE_NAME; ?></title>
    </head>
    <body>
        <?php
            include_once(__DIR__.'/assets/common/navigation.php');
        ?>
        <div class="bg-white relative w-full px-4 py-16 mx-auto md:px-24 lg:px-8 lg:py-20">
            <div class="mb-16 md:mb-0 md:max-w-xl sm:mx-auto md:text-center">
                <h2 class="mb-5 font-sans text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl sm:leading-none">
                    <span class="inline-block text-gray-900">Saturn is Installed!</span>
                </h2>
                <p class="mb-5 text-base text-gray-700 md:text-lg">
                    Welcome to your new website. Visit the <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel" class="text-blue-500 hover:text-blue-400">control panel</a> to edit your website.
                </p>
                <p class="mb-5 text-gray-700 text-xs">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel" class="text-blue-500 hover:text-blue-400">Control Panel</a> | <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/admin" class="text-blue-500 hover:text-blue-400">Admin Panel</a>
                </p>
            </div>
        </div>
    </body>
</html>
