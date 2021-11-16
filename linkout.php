<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $errorScreen = true;
            include_once __DIR__.'/common/global_public.php';
        ?>
        <title><?php echo CONFIG_SITE_NAME; ?></title>
    </head>
    <body>
        <?php include_once __DIR__.'/common/navigation.php'; ?>

        <main class="bg-white relative overflow-hidden h-screen relative">
            <div class="container mx-auto h-screen pt-32 md:pt-0 px-6 z-10 flex items-center justify-between">
                <div class="container mx-auto px-6 flex flex-col-reverse lg:flex-row justify-between items-center relative">
                    <div class="w-full mb-16 md:mb-8 text-center lg:text-left">
                        <h1 class="text-center lg:text-left text-5xl lg:text-8xl mt-12 md:mt-0 text-gray-700">
                            External Link
                        </h1>
                        <p class="text-base text-gray-700 mt-4">
                            You are leaving the <?php echo CONFIG_SITE_NAME; ?> website, and are about to go to <?php echo checkInput('DEFAULT', $_GET['url']); ?> where different Terms of Use and Privacy Policy will apply.
                        </p>
                        <button onclick="window.history.back();" class="px-2 py-2 w-36 mt-16 font-light transition ease-in duration-200 hover:bg-gray-200 border-2 text-lg border-gray-700 focus:outline-none">
                            Go back
                        </button>
                        <button onclick="location.href='<?php echo checkInput('DEFAULT', $_GET['url']); ?>';" class="px-2 py-2 w-36 mt-16 font-light transition ease-in duration-200 hover:bg-gray-200 border-2 text-lg border-gray-700 focus:outline-none">
                            Continue
                        </button>
                    </div>
                    <div class="block w-full mx-auto md:mt-0 relative max-w-md lg:max-w-2xl">
                        <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/error.svg" alt="Linkout Image">
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>