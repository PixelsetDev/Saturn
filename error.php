<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $errorScreen = true;
            include_once __DIR__.'/assets/common/global_public.php';
        ?>
        <title>Error - <?php echo CONFIG_SITE_NAME; ?></title>
    </head>
    <body>
        <?php include_once __DIR__.'/assets/common/navigation.php'; ?>

        <main class="bg-white relative overflow-hidden h-screen relative">
            <div class="container mx-auto h-screen pt-32 md:pt-0 px-6 z-10 flex items-center justify-between">
                <div class="container mx-auto px-6 flex flex-col-reverse lg:flex-row justify-between items-center relative">
                    <div class="w-full mb-16 md:mb-8 text-center lg:text-left">
                        <h1 class="text-center lg:text-left text-5xl lg:text-8xl mt-12 md:mt-0 text-gray-700">
                            Error: <?php
                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == 'db_conn') {
                                        echo 'Database Error.';
                                    } elseif ($_GET['error'] == '401') {
                                        echo 'Unauthorized.';
                                    } elseif ($_GET['error'] == '403') {
                                        echo 'Access Denied.';
                                    } elseif ($_GET['error'] == '404') {
                                        echo 'Page not Found.';
                                    } elseif ($_GET['error'] == '405') {
                                        echo 'Method not Allowed.';
                                    } elseif ($_GET['error'] == '408') {
                                        echo 'Request Timeout.';
                                    } elseif ($_GET['error'] == '413') {
                                        echo 'Payload Too Large.';
                                    } elseif ($_GET['error'] == '414') {
                                        echo 'URI Too Long.';
                                    } elseif ($_GET['error'] == '425') {
                                        echo 'Too Early.';
                                    } elseif ($_GET['error'] == '429') {
                                        echo 'Too Many Requests.';
                                    } elseif ($_GET['error'] == '500') {
                                        echo 'Internal Server Error.';
                                    } elseif ($_GET['error'] == '501') {
                                        echo 'Not Implemented.';
                                    } elseif ($_GET['error'] == '502') {
                                        echo 'Bad Gateway.';
                                    } elseif ($_GET['error'] == '503') {
                                        echo 'Service Unavailable.';
                                    } elseif ($_GET['error'] == '504') {
                                        echo 'Gateway Timeout.';
                                    } else {
                                        echo 'Sorry, an error occurred.';
                                    }
                                    log_console('Saturn][ERROR', $_GET['error']);
                                } else {
                                    echo 'Sorry, an error occurred.';
                                }
                            ?>
                        </h1>
                        <p class="text-base text-gray-700 mt-4">
                            We've logged this error and will investigate it accordingly. Sorry for any inconvenience caused.
                        </p>
                        <button onclick="location.href='<?php echo CONFIG_INSTALL_URL; ?>';" class="px-2 py-2 w-36 mt-16 font-light transition ease-in duration-200 hover:bg-gray-200 border-2 text-lg border-gray-700 focus:outline-none">
                            Go back home
                        </button>
                    </div>
                    <div class="block w-full mx-auto md:mt-0 relative max-w-md lg:max-w-2xl">
                        <img src="<?php echo CONFIG_INSTALL_URL; ?>/assets/images/error.svg" alt="Error Image" />
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>