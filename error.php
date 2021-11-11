<?php
$errorScreen = true;
include_once __DIR__ . '/assets/common/global_public.php';

if (isset($_GET['error'])) {
    $error = checkInput('DEFAULT', $_GET['error']);
    if ($_GET['error'] == 'db_conn') {
        $title = 'Database Error.';
        $message = 'That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_error('ERROR', 'A \'Database Error\' error occurred. Error code: '.$error);
    } elseif ($error == '401' || $error == '403') {
        $title = 'You\'re not permitted to access this page.';
        $message = 'Error code: '.$error.'. For more information please contact the website administrator.';
    } elseif ($error == '404') {
        $title = 'Page not Found.';
        $message = 'Error code: '.$error.". If you clicked a link on our website, please contact us to let us know it's broken. If you typed in the page URL yourself, please check your spelling and try again.";
    } elseif ($error == '405') {
        $title = 'Method Not Allowed.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_error('ERROR', 'A \'Method Not Allowed\' error occurred. Error code: '.$error);
    } elseif ($error == '408') {
        $title = 'Request Timeout.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_error('ERROR', 'A \'Request Timeout\' error occurred. Error code: '.$error);
    } elseif ($error == '413' || $error == '414') {
        $title = 'Size Limit Exceeded.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_error('ERROR', 'A \'Size Limit Exceeded\' error occurred. Error code: '.$error);
    } elseif ($_GET['error'] == '425') {
        $title = 'Too Early.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_error('ERROR', 'A \'Too Early\' error occurred. Error code: '.$error);
    } elseif ($_GET['error'] == '429') {
        $title = 'Too Many Requests.';
        $message = 'Error code: '.$error.'. Our servers are experiencing high load at this moment in time, please try again later.';
    } elseif ($error == '500' || $error == '501' || $error == '502' || $error == '503' || $error == '504') {
        $title = 'Server Error.';
        $message = 'Error code: '.$error.'. That\'s our bad. We\'ve logged it and will investigate the cause.';
        log_error('ERROR', 'A \'Server Error\' error occurred. Error code: '.$error);
    } else {
        $title = 'Sorry, an error occurred.';
        $message = 'The specified error code ('.$error.') does not appear to exist in our system\'s error handling script. We\'ve logged it and will investigate the cause.';
        log_error('ERROR', 'An unidentified error occurred. Error code: '.$error);
    }
    log_console('Saturn][ERROR', $error);
} else {
    $title = 'Sorry, an error occurred.';
    $message = 'We were unable to find the cause of this error. For more information please contact the website administrator.';
}
if (strpos($_SERVER['REQUEST_URI'], 'access_method=saturn_iframe_preview')) {
    ?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Error Displaying Preview</title>
</head>
<body class="bg-red-700 p-4">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="3 3 16 16" width="25%"><defs><linearGradient gradientUnits="userSpaceOnUse" y2="-2.623" x2="0" y1="986.67"><stop stop-color="#ffffff"/><stop offset="1" stop-color="#ffffff"/></linearGradient><linearGradient id="0" gradientUnits="userSpaceOnUse" y1="986.67" x2="0" y2="-2.623"><stop stop-color="#ffffff"/><stop offset="1" stop-color="#ffffff"/></linearGradient><linearGradient gradientUnits="userSpaceOnUse" x2="1" x1="0" xlink:href="#0"/></defs><g transform="matrix(2 0 0 2-11-2071.72)"><path transform="translate(7 1037.36)" d="m4 0c-2.216 0-4 1.784-4 4 0 2.216 1.784 4 4 4 2.216 0 4-1.784 4-4 0-2.216-1.784-4-4-4" fill="#ffffff"/><path d="m11.906 1041.46l.99-.99c.063-.062.094-.139.094-.229 0-.09-.031-.166-.094-.229l-.458-.458c-.063-.062-.139-.094-.229-.094-.09 0-.166.031-.229.094l-.99.99-.99-.99c-.063-.062-.139-.094-.229-.094-.09 0-.166.031-.229.094l-.458.458c-.063.063-.094.139-.094.229 0 .09.031.166.094.229l.99.99-.99.99c-.063.062-.094.139-.094.229 0 .09.031.166.094.229l.458.458c.063.063.139.094.229.094.09 0 .166-.031.229-.094l.99-.99.99.99c.063.063.139.094.229.094.09 0 .166-.031.229-.094l.458-.458c.063-.062.094-.139.094-.229 0-.09-.031-.166-.094-.229l-.99-.99" fill="#B91C1C"/></g></svg>
<h1 class="text-3xl text-white mt-4">
    Error Displaying Preview
</h1>
<p class="text-base text-white mt-4">
    <?php echo checkOutput('DEFAULT', $title); ?>
</p>
</body>
</html>
<?php
} else { ?><!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once __DIR__ . '/assets/common/vendors.php'; ?>

    <title>Error<?php if (isset($error)) {
        echo ' '.checkOutput('DEFAULT', $error);
    } ?> - <?php echo CONFIG_SITE_NAME; ?></title>
</head>
<body>
<?php include_once __DIR__ . '/assets/common/navigation.php'; ?>

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
                <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/error.svg" alt="Error Image" />
            </div>
        </div>
    </div>
</main>
</body>
</html><?php } ?>