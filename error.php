<?php
$errorScreen = true;
include_once __DIR__.'/assets/common/global_public.php';

if (isset($_GET['error'])) {
    $error = checkInput('DEFAULT', $_GET['error']);
    if ($_GET['error'] == 'db_conn') {
        $title = 'Database Error.';
        $message = 'That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_file('Saturn][ERROR', 'A \'Database Error\' error occurred. Error code: '.$error);
    } elseif ($error == '401' || $error == '403') {
        $title = 'You\'re not permitted to access this page.';
        $message = 'Error code: '.$error.'. For more information please contact the website administrator.';
    } elseif ($error == '404') {
        $title = 'Page not Found.';
        $message = 'Error code: '.$error.'. If you clicked a link on our website, please contact us to let us know it\'s broken. If you typed in the page URL yourself, please check your spelling and try again.';
    } elseif ($error == '405') {
        $title = 'Method Not Allowed.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_file('Saturn][ERROR', 'A \'Method Not Allowed\' error occurred. Error code: '.$error);
    } elseif ($error == '408') {
        $title = 'Request Timeout.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_file('Saturn][ERROR', 'A \'Request Timeout\' error occurred. Error code: '.$error);
    } elseif ($error == '413' || $error == '414') {
        $title = 'Size Limit Exceeded.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_file('Saturn][ERROR', 'A \'Size Limit Exceeded\' error occurred. Error code: '.$error);
    } elseif ($_GET['error'] == '425') {
        $title = 'Too Early.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_file('Saturn][ERROR', 'A \'Too Early\' error occurred. Error code: '.$error);
    } elseif ($_GET['error'] == '429') {
        $title = 'Too Many Requests.';
        $message = 'Error code: '.$error.'. Our servers are experiencing high load at this moment in time, please try again later.';
    } elseif ($error == '500' || $error == '501' || $error == '502' || $error == '503' || $error == '504') {
        $title = 'Server Error.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_file('Saturn][ERROR', 'A \'Server Error\' error occurred. Error code: '.$error);
    } else {
        $title = 'Sorry, an error occurred.';
        $message = 'The specified error code ('.$error.') does not appear to exist in our system\'s error handling script. We\'ve logged it and will investigate the cause.';
        log_file('Saturn][ERROR', 'An unidentified error occurred. Error code: '.$error);
    }
    log_console('Saturn][ERROR', $error);
} else {
    $title = 'Sorry, an error occurred.';
    $message = 'We were unable to find the cause of this error. For more information please contact the website administrator.';
}
?><!DOCTYPE html>
<html lang="en">
    <head>

        <title>Error<?php if(isset($error)) {echo ' '.checkOutput('DEFAULT', $error);} ?> - <?php echo CONFIG_SITE_NAME; ?></title>
    </head>
    <body>
        <?php include_once __DIR__.'/assets/common/navigation.php'; ?>

        <main class="bg-white relative overflow-hidden h-screen relative">
            <div class="container mx-auto h-screen pt-32 md:pt-0 px-6 z-10 flex items-center justify-between">
                <div class="container mx-auto px-6 flex flex-col-reverse lg:flex-row justify-between items-center relative">
                    <div class="w-full mb-16 md:mb-8 text-center lg:text-left">
                        <h1 class="text-center lg:text-left text-5xl lg:text-8xl mt-12 md:mt-0 text-gray-700">
                            <?php echo checkOutput('DEFAULT', $title); ?>
                        </h1>
                        <p class="text-base text-gray-700 mt-4">
                            <?php echo checkOutput('DEFAULT', $message); ?>
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