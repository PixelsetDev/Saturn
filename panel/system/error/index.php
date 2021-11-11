<?php
    session_start();
    if (isset($_GET['err'])) {
        $err = checkInput('DEFAULT', $_GET['err']);
        if ($err == '404') {
            $errorTitle = 'Error 404: Page not Found.';
            $errorDescription = 'Sorry, the page you requested could not be found.';
        } elseif ($err == '403') {
            $errorTitle = 'Error 403';
            $errorDescription = 'Sorry, the page you requested could not be found.';
        } elseif ($err == 'security') {
            $errorTitle = 'Security Error';
            $errorDescription = 'Sorry, our security system has detected malicious activity and has suspended Saturn CMS.<br><br>For more information please contact the website administrator.';
        } elseif ($err == 'gss2') {
            session_destroy();
            $errorTitle = 'Whoops!';
            $errorDescription = 'Error GSS2: We were unable to authenticate your session, this could be because you\'ve logged in from a different location.<br>To continue, please re-log into Saturn.<br><br>For more information please contact the website administrator.';
        } else {
            $errorTitle = 'Error';
            $errorDescription = 'Sorry, an unexpected error occurred.';
        }
    } else {
        $errorTitle = 'Error';
        $errorDescription = 'Sorry, an unexpected error occurred.';
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $errorTitle; ?> - Saturn Panel</title>
        <?php
            include_once __DIR__ . '/../../../assets/common/global_public.php';
            include_once __DIR__ . '/../../../assets/common/panel/vendors.php';
            include_once __DIR__ . '/../../../assets/common/panel/theme.php';
        ?>

    </head>
    <body class="bg-gray-200">
        <header class="bg-gray-900 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-100"><a href="<?php echo CONFIG_INSTALL_URL; ?>/panel">Saturn Panel</a></h1>
            </div>
        </header>
        <div class="container mx-auto px-4">
            <section class="py-8 px-4 text-center">
                <div class="max-w-auto mx-auto">
                    <div class="md:max-w-lg mx-auto">
                        <i class="fas fa-10x fa-exclamation-triangle text-red-500" aria-hidden="true"></i>
                    </div>
                    <h2 class="mt-8 text-xl lg:text-5xl text-red-700"><?php echo $errorTitle; ?></h2>
                    <p class="mt-6 text-sm lg:text-base text-red-500"><?php echo $errorDescription; ?></p>
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/dashboard" class="mt-6 bg-red-500 hover:bg-red-400 hover:shadow-xl text-white font-light py-4 px-6 rounded inline-block ">Back To Dashboard</a>
                </div>
            </section>
        </div>
    </body>
</html>