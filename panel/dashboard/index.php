<?php
    session_start();
    ob_start();
    include_once __DIR__.'/../../common/global_private.php';
    if ($_SESSION['2FA_verified'] || !get_user_settings_security_2fa($_SESSION['id'])) {
        ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../common/panel/theme.php';
        $id = $_SESSION['id']; ?>
        <title>Saturn Panel</title>

        <?php
        include_once __DIR__.'/../../common/panel/vendors.php';
        if (isset($_GET['dismissNotif'])) {
            $nid = $_GET['dismissNotif'];
            update_notification_dismiss($nid);
            header('Location: '.CONFIG_INSTALL_URL.'/panel/dashboard');
        }
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 'permission') {
                $errorMsg = 'You do not have the required permissions to do that.';
            } elseif ($error == 'no_user') {
                $errorMsg = 'User not found.';
            } else {
                $errorMsg = 'An unknown error occurred.';
            }
        }
        if (isset($_GET['warning'])) {
            $error = $_GET['warning'];
            if ($error == 'permission') {
                $errorMsg = 'You do not have the required permissions to do that.';
            } else {
                $warningMsg = 'An unknown warning occurred.';
            }
        } ?>

    </head>
    <body class="mb-14">
        <?php
        if (!get_user_accepted_terms($_SESSION['id']) && CONFIG_WELCOME_SCREEN) {
            if (isset($_GET['acceptTerms']) && $_GET['acceptTerms'] == 'true') {
                update_user_accepted_terms($_SESSION['id'], true);
                echo alert('ERROR', 'Please try again.');
            } ?>
        <div class="absolute top-0 bg-white z-50">
            <header class="bg-white shadow relative">
                <div class="py-6 px-4 sm:px-6 lg:px-8 flex w-full">
                    <h1 class="text-3xl font-bold leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900 flex-grow">Welcome to Saturn</h1>
                    <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/logo.png" class="h-8 w-auto" alt="<?php echo CONFIG_SITE_NAME; ?>">
                </div>
            </header>
            <form method="POST" action="index.php" class="py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-gray-50">
                    Hey <?php echo get_user_firstname($_SESSION['id']); ?>, welcome to Saturn. Since it's your first time using Saturn we've got a few things to go through with you before you can get started.<br>
                </p>
                <h2 class="mt-8 mb-2 text-2xl leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900">About You</h2>
                <p class="text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-gray-50">
                    Everyone on Saturn has an account that keeps track of who you are, your account is <?php echo get_user_username($_SESSION['id']); ?>. You can change account information in your profile settings which can be accessed by clicking on your name in the menu. There's also a number of personal settings that can be changed there too, so it's worth checking it out.<br>
                    <br>
                    <div class="grid grid-cols-2">
                        <div>
                            <p class="text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-gray-50">
                                Your role is <?php echo get_user_role($_SESSION['id']); ?>. This means that you can:
                            </p>
                            <ul class="list-disc ml-4 text-<?php echo THEME_PANEL_COLOUR; ?>-700">
                                <li>Write Pages and Articles.</li>
                                <?php
                                if (get_user_roleID($_SESSION['id'] >= '3')) {
                                    ?>
                                    <li>Approve Pages and Articles.</li>
                                    <?php
                                }
            if (get_user_roleID($_SESSION['id'] >= '4')) {
                ?>
                                    <li>Manage the Website's Core Settings</li>
                                    <li>Manage the the Users and their permissions.</li>
                                    <?php
            } ?>
                                <li>Join the Team Chat and Socialise with Team Members.</li>
                                <li>and so much more!</li>
                            </ul>
                        </div>
                        <div class="md:block hidden">
                            <p class="text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-gray-50 mx-10">
                                This is your Profile, you can edit this later in Saturn.
                            </p>
                            <div class="mx-10 rounded-md shadow-xl p-4">
                                <img class="rounded-full h-16 w-16 inline m-1" src="<?php echo get_user_profilephoto($_SESSION['id']); ?>" alt="<?php echo get_user_fullname($_SESSION['id']); ?>">
                                <h3 class="text-xl font-bold inline"><?php echo get_user_fullname($_SESSION['id']); ?></h3>
                                <p class="mt-4">
                                    <?php echo get_user_bio($_SESSION['id']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </p>
                <h2 class="mt-8 mb-2 text-2xl leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900">Personal Settings and Preferences</h2>
                <p class="text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-gray-50">
                    We've got a number of personal preferences and settings available for you. You're able to find and change these in your profile edit / profile settings page by clicking on your name in the main menu. You can set how and where you get notifications, if you'd like two-factor authentication and abbreviate your surname for further privacy. At the moment you get notifications in the Saturn dashboard, but you can get email notifications by enabling them in your profile settings.
                </p>
                <?php
                    if (!get_user_accepted_terms($_SESSION['id']) && CONFIG_WELCOME_SCREEN_SHOW_TERMS) {
                        $output = json_decode(file_get_contents(__DIR__.'/../../assets/storage/terms.json'));
                        if ($output->data->termsandconditions != null) {
                            ?>
                <h2 class="mt-8 mb-2 text-2xl leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900">Terms and Conditions</h2>
                <p class="text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-gray-50">
                    These are the Terms and Conditions of the Saturn System set out by your website administrator, you'll need to read these before you can continue.<br>
                    By clicking the continue button at the bottom of the screen, you accept these Terms and Conditions.
                </p>
                <div class="w-full h-1/2 shadow-xl overflow-y-scroll text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 border p-4 bg-<?php echo THEME_PANEL_COLOUR; ?>-100">
                    <?php echo $output->data->termsandconditions; ?>
                </div>
                <?php
                        }
                        if ($output->data->privacypolicy != null) {
                            ?>
                <h2 class="mt-8 mb-2 text-2xl leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900">Privacy Policy</h2>
                <p class="text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-gray-50">
                    This is the Privacy Policy your website administrator has created. You can also see how Saturn manages your data at <a href="https://www.saturncms.net/privacy" class="underline" rel="noopener" target="_blank">saturncms.net/privacy</a>, you'll need to read these before you can continue.<br>
                    By clicking the continue button at the bottom of the screen, you accept this Privacy Policy.
                </p>
                <div class="w-full h-1/2 shadow-xl overflow-y-scroll text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 border p-4 bg-<?php echo THEME_PANEL_COLOUR; ?>-100">
                    <?php echo $output->data->privacypolicy; ?>
                </div>
                <?php
                        } ?>
                <?php
                    } ?>
                <h2 class="mt-8 mb-2 text-2xl leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900">Let's go!</h2>
                <p class="text-lg text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-gray-50">
                    You're all set and ready to go! If you need any further help you can reach out to your Website Administrator via Email here: <a href="mailto:<?php echo CONFIG_EMAIL_ADMIN; ?>" class="underline" rel="noopener"><?php echo CONFIG_EMAIL_ADMIN; ?></a> or read the Saturn Documentation at <a href="https://docs.saturncms.net" class="underline" rel="noopener" target="_blank">https://docs.saturncms.net</a>
                </p>
                <a href="?acceptTerms=true" class="mt-10 hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-check" aria-hidden="true"></i>
                    </span>
                    Continue
                </a>
            </form>
        </div>
        <?php
            exit;
        } ?>
        <?php include_once __DIR__.'/../../common/panel/navigation.php'; ?>

        <header class="bg-white shadow relative <?php $notifCount = get_notification_count($_SESSION['id']);
        if ($notifCount > '0') {
            echo 'pb-28 md:pb-1';
        } ?>">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Dashboard</h1>
            </div>
            <?php if ($notifCount > '0') {
            echo'<a href="'.CONFIG_INSTALL_URL.'/panel/dashboard/?dismissNotif='.get_latest_notification_id($_SESSION['id']).'" class="m-1 bg-white rounded-lg border-gray-300 border p-3 shadow-lg absolute md:top-0 right-0 max-w-sm md:max-w-xl max-h-20 overflow-y-scroll">
                <div class="flex flex-row">
                    <span class="animate-pulse bg-blue-500 h-6 w-6 rounded-full relative text-center">
                        <i class="fas fa-info text-white self-center object-center py-1" aria-hidden="true"></i>
                    </span>
                    <div class="ml-2 mr-6">
                        <div class="flex w-full">
                            <span class="font-semibold flex-grow">'.get_latest_notification_title($_SESSION['id']).'</span>
                            <span class="text-red-500"><i class="fas fa-times text-red-500 self-center object-center py-1" aria-hidden="true"></i></span>
                        </div>
                        <span class="block text-gray-500">'.get_latest_notification_content($_SESSION['id']).'</span>
                    </div>
                </div>
            </a>';
        } ?>
        </header>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <?php
            if (isset($errorMsg)) {
                echo alert('ERROR', $errorMsg);
                unset($errorMsg);
            }
        if (isset($warningMsg)) {
            echo alert('WARNING', $warningMsg);
            unset($warningMsg);
        }
        if (CONFIG_DEBUG) {
            echo alert('WARNING', 'Debug mode is enabled. This is NOT recommended in production environments.');
        }
        if (get_user_roleID($_SESSION['id']) > 3) {
            $remoteVersion = file_get_contents('https://link.saturncms.net/?latest_version');
            if ($remoteVersion != SATURN_VERSION) {
                echo '<br>
                    <div class="w-full mr-1 my-1 duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">An update is available.</h6>
                            <a href="'.CONFIG_INSTALL_URL.'/panel/admin" class="text-'.THEME_PANEL_COLOUR.'-500 hover:text-'.THEME_PANEL_COLOUR.'-400 underline">Update</a>.
                        </div>
                    </div>';
            }
        } ?>

            <div class="flex flex-wrap space-x-4">
                <div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-2xl w-auto p-4 bg-white dark:bg-gray-800">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/pages">
                        <div class="flex items-center">
                            <span class="bg-green-500 h-10 w-10 rounded-full relative text-center">
                                <i class="far fa-file fa-lg text-white self-center object-center py-3" aria-hidden="true"></i>
                            </span>
                            <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                                Pages
                            </p>
                        </div>
                        <div class="flex flex-col justify-start">
                            <p class="text-gray-800 text-4xl text-left dark:text-white font-bold my-4">
                                <?php
                                    $result = mysqli_query($conn, 'SELECT * FROM `'.DATABASE_PREFIX.'pages` WHERE 1;');
        $rowCount = mysqli_num_rows($result);
        echo $rowCount; ?>
                            </p>
                        </div>
                    </a>
                </div>

                <div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-2xl w-auto p-4 bg-white dark:bg-gray-800 ml-4">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/articles">
                        <div class="flex items-center">
                            <span class="bg-green-500 h-10 w-10 rounded-full relative text-center">
                                <i class="far fa-newspaper fa-lg text-white self-center object-center py-3" aria-hidden="true"></i>
                            </span>
                            <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                                Articles
                            </p>
                        </div>
                        <div class="flex flex-col justify-start">
                            <p class="text-gray-800 text-4xl text-left dark:text-white font-bold my-4">
                                <?php
                                    $result = mysqli_query($conn, 'SELECT * FROM `'.DATABASE_PREFIX."articles` WHERE `author_id` = '".$_SESSION['id']."';");
        $rowCount = mysqli_num_rows($result);
        echo $rowCount; ?>
                            </p>
                        </div>
                    </a>
                </div>

                <?php if (get_user_roleID($_SESSION['id']) > 2) { ?>
                <div x-data="{ open: false }" class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-2xl w-auto p-4 bg-white dark:bg-gray-800">
                    <a @click="open = true" class="cursor-pointer">
                        <div class="flex items-center">
                            <span class="bg-green-500 h-10 w-10 rounded-full relative text-center">
                                <i class="fas fa-search fa-lg text-white self-center object-center py-3" aria-hidden="true"></i>
                            </span>
                            <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                                Pending <br class="md:hidden block">Approvals
                            </p>
                        </div>
                        <div class="flex flex-col justify-start">
                            <p class="text-gray-800 text-4xl text-left dark:text-white font-bold my-4">
                                <?php
                                    $result = mysqli_query($conn, 'SELECT `content` FROM `'.DATABASE_PREFIX.'pages_pending` WHERE `content` IS NOT NULL;');
                                    $rows = mysqli_num_rows($result);

                                    $result2 = mysqli_query($conn, 'SELECT * FROM `'.DATABASE_PREFIX."articles` WHERE `status` = 'PENDING';");
                                    $rows2 = mysqli_num_rows($result2);

                                    $finalRows = $rows + $rows2;
                                    echo $finalRows;
                                ?>
                            </p>
                        </div>
                    </a>
                    <?php echo display_modal('INFO', 'Approvals', 'Please select an option below. There are currently '.$rows.' pending page approvals and '.$rows2.' pending article approvals.', '<div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <a href="'.CONFIG_INSTALL_URL.'/panel/articles/approvals" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 bg-'.THEME_PANEL_COLOUR.'-100 hover:bg-'.THEME_PANEL_COLOUR.'-200 md:py-1 md:text-rg md:px-10">
                                        Article Approvals&nbsp;<span class="px-1 h-5 bg-red-500 rounded-full text-white text-sm">'.$rows2.'</span>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="'.CONFIG_INSTALL_URL.'/panel/pages/approvals" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 bg-'.THEME_PANEL_COLOUR.'-100 hover:bg-'.THEME_PANEL_COLOUR.'-200 md:py-1 md:text-rg md:px-10">
                                        Page Approvals&nbsp;<span class="px-1 h-5 bg-red-500 rounded-full text-white text-sm">'.$rows.'</span>
                                    </a>
                                </div>');

                    unset($result, $result2, $rows, $rows2, $finalRows); ?>
                </div>
                <?php } ?>
            </div>
            <div class="flex flex-wrap space-x-4">
                <?php
                    $result = mysqli_query($conn, 'SELECT `id`, `edits` FROM `'.DATABASE_PREFIX.'users_statisticcs` WHERE 1 ORDER BY edits;');
        $row = mysqli_fetch_row($result);
        $uid = $row[0]; ?>
                <div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-xl w-full md:w-80 p-4 bg-white dark:bg-gray-800 relative overflow-hidden mt-4">
                    <div class="flex items-center">
                        <span class="bg-green-500 h-10 w-10 rounded-full relative text-center">
                            <i class="fas fa-pencil-alt fa-lg text-white self-center object-center py-3" aria-hidden="true"></i>
                        </span>
                        <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                            Top Writers
                        </p>
                    </div>
                    <div class="flex space-x-4">
                        <?php
                            $x = 0;
        $result = mysqli_query($conn, 'SELECT `id`, `edits` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE 1 ORDER BY edits DESC;');
        $row = mysqli_fetch_row($result);
        $uid = $row[0];
        while ($uid != null && $x != '4') {
            if (get_user_roleID($uid) != '0' && get_user_roleID($uid) != '1') {
                echo '<div class="flex-grow">
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    <a href="'.get_user_profile_link($uid).'" class="block relative">
                                        <img alt="'.get_user_fullname($uid).'" src="'.get_user_profilephoto($uid).'" class="mx-auto object-cover rounded-full h-10 w-10 "/>
                                    </a>
                                </div>
                                <a href="'.get_user_profile_link($uid).'" class="text-gray-600 dark:text-gray-400 text-xs mt-2">
                                    '.get_user_fullname($uid).'
                                </a>
                                <a href="'.get_user_profile_link($uid).'" class="mt-1 text-xs text-white bg-';
                if (get_user_statistics_edits($uid) == '0') {
                    echo 'red';
                } elseif (get_user_statistics_edits($uid) < '6') {
                    echo 'yellow';
                } else {
                    echo 'green';
                }
                echo'-500 rounded-full p-1">
                                    '.$row[1].' Edits
                                </a>
                            </div>
                        </div>';
            }
            $row = mysqli_fetch_row($result);
            if (isset($row[0])) {
                $uid = $row[0];
            }
            $x++;
        } ?>
                    </div>
                </div><?php
                if (get_user_roleID($id) > '2') {
                    $result = mysqli_query($conn, 'SELECT `id`, `edits` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE 1 ORDER BY edits;');
                    $row = mysqli_fetch_row($result);
                    $uid = $row[0];
                    echo '<div class="flex-grow shadow-lg hover:shadow-xl transition-shadow duration-200 rounded-xl w-full md:w-80 p-4 bg-white dark:bg-gray-800 relative overflow-hidden mt-4">
                    <div class="flex items-center">
                        <span class="bg-green-500 h-10 w-10 rounded-full relative text-center">
                            <i class="fas fa-pencil-ruler fa-lg text-white self-center object-center py-3" aria-hidden="true"></i>
                        </span>
                        <p class="text-2xl text-gray-700 dark:text-gray-50 ml-2">
                            Top Editors
                        </p>
                    </div>
                    <div class="flex space-x-4">';
                    $x = 0;
                    $result = mysqli_query($conn, 'SELECT `id`, `approvals` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE 1 ORDER BY approvals DESC;');
                    $row = mysqli_fetch_row($result);
                    $uid = $row[0];
                    while ($uid != null && $x != '4') {
                        if (get_user_roleID($uid) > '2') {
                            echo '<div class="flex-grow">
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    <a href="'.get_user_profile_link($uid).'" class="block relative">
                                        <img alt="'.get_user_fullname($uid).'" src="'.get_user_profilephoto($uid).'" class="mx-auto object-cover rounded-full h-10 w-10 "/>
                                    </a>
                                </div>
                                <a href="'.get_user_profile_link($uid).'" class="text-gray-600 dark:text-gray-400 text-xs mt-2">
                                    '.get_user_fullname($uid).'
                                </a>
                                <a href="'.get_user_profile_link($uid).'" class="mt-1 text-xs text-white bg-';
                            if (get_user_statistics_approvals($uid) == '0') {
                                echo 'red';
                            } elseif (get_user_statistics_approvals($uid) < '6') {
                                echo 'yellow';
                            } else {
                                echo 'green';
                            }
                            echo'-500 rounded-full p-1">
                                    '.$row[1].' Approvals
                                </a>
                            </div>
                        </div>';
                        }
                        $x++;
                        $row = mysqli_fetch_row($result);
                        if (isset($row[0])) {
                            $uid = $row[0];
                        }
                    }
                    echo '</div>
                </div>';
                } ?>
            </div>

            <?php display_dashboard_statistics($_SESSION['id']); ?>

            <div class="flex mt-4 space-x-4">
                <div class="flex-grow shadow-lg rounded-xl w-1/6 bg-white text-<?php echo THEME_PANEL_COLOUR; ?>-500 relative overflow-hidden">
                    <div class="text-center">
                        <p class="text-xl font-medium mt-4 mx-2">Your Total Views:</p>
                        <p class="mt-2"><?php echo get_user_statistics_views($_SESSION['id']); ?></p>
                    </div>
                    <div class="w-full h-3 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 mt-3">
                        <div class="w-full h-full text-center text-xs text-white bg-<?php echo THEME_PANEL_COLOUR; ?>-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
    } else {
        header('Location: '.CONFIG_INSTALL_URL.'/panel/account/signin/verify?type=2&username='.get_user_username($_SESSION['id']));
    }
    ob_end_flush();
?>