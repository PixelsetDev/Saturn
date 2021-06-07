<?php
include_once(__DIR__ . '/../../../assets/common/global_public.php');

session_start();
session_destroy();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign out - Saturn Panel</title>
        <?php
        include_once(__DIR__ . '/../../../assets/common/panel/vendors.php');
        include_once(__DIR__ . '/../../../assets/common/panel/theme.php');
        ?>

    </head>
    <body>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900"><a href="<?php echo CONFIG_INSTALL_URL;?>/panel">Saturn Panel</a></h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="Saturn">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                            Sign out.
                        </h2>
                        <?php alert('SUCCESS', 'You have been signed out.'); ?>
                    </div>

                    <div class="flex space-x-2">
                        <div class="flex-grow">
                            <a href="<?php echo CONFIG_INSTALL_URL; ?>" class="hover:shadow-xl group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-home"></i>
                                </span>
                                Exit
                            </a>
                        </div>
                        <div class="flex-grow">
                            <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/account/signin" class="hover:shadow-xl group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-lock"></i>
                                </span>
                                Sign in
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>