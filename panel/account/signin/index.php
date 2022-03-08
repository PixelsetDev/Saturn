<?php
    ob_start();
    session_start();

    include_once __DIR__.'/../../../common/global_public.php';

    if (isset($_POST['login']) || isset($_GET['login'])) {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $username = checkInput('DEFAULT', $username);
            $password = checkInput('DEFAULT', $password);

            $sql = 'SELECT * FROM `'.DATABASE_PREFIX."users` WHERE `email` = '".$username."' OR `username` = '".$username."';";

            $rs = mysqli_query($conn, $sql);
            $getNumRows = mysqli_num_rows($rs);
            $getUserRow = mysqli_fetch_assoc($rs);

            if (password_verify($password, $getUserRow['password'])) {
                unset($password);
                if ($getUserRow['role_id'] == '1') {
                    $errorMsg = __('Error:Account_NotApproved');
                } elseif ($getUserRow['role_id'] == '0') {
                    $errorMsg = __('Error:Account_Restricted');
                } else {
                    require_once __DIR__.'/../../../common/processes/database/get/user.php';
                    require_once __DIR__.'/../../../common/processes/database/get/user_settings.php';
                    require_once __DIR__.'/../../../common/processes/database/update/user.php';
                    if (get_user_last_login_ip($getUserRow['id']) != hash_ip($_SERVER['REMOTE_ADDR'])) {
                        echo '<meta http-equiv="refresh" content="0; url='.CONFIG_INSTALL_URL.'/panel/account/signin/verify/?type=1&username='.$getUserRow['username'].'">';
                    } else {
                        $session['id'] = $getUserRow['id'];
                        $session['username'] = $getUserRow['username'];
                        $session['role_id'] = $getUserRow['role_id'];
                        $session['2FA_verified'] = false;
                        unset($getUserRow);

                        $newKey = generate_uka_key();
                        update_user_key($session['id'], $newKey);
                        $session['user_key'] = $newKey;

                        $_SESSION = $session;
                        echo '<meta http-equiv="refresh" content="0; url='.CONFIG_INSTALL_URL.'/panel/dashboard">';
                    }
                    exit;
                }
                unset($getUserRow['password']);
            } else {
                unset($password, $row, $rs, $sql);
                $errorMsg = __('Error:Signin_Incorrect');
                log_file('SATURN][SECURITY', __('Error:Account_FailedLogin_1').' '.$username.' '.__('Error:Account_FailedLogin_2').' '.hash_ip($_SERVER['REMOTE_ADDR']));
            }
        } else {
            $errorMsg = __('Error:LoginEmpty');
        }
    }

    if (isset($_GET['signedout'])) {
        if ($_GET['signedout'] == 'true') {
            $errorMsg = __('Error:Signin_Required');
        }
        if ($_GET['signedout'] == 'role') {
            $errorMsg = __('Error:Signin_Required').' ('.__('Error:InvalidRole').')';
        }
        if ($_GET['signedout'] == 'key') {
            $errorMsg = __('Error:Signin_Required').' ('.__('Error:InvalidSecurityKey').')';
        }
        if ($_GET['signedout'] == 'verified') {
            $successMsg = __('Panel:SignIn_IPVerified');
        }
        if ($_GET['signedout'] == 'permission') {
            $errorMsg = __('Error:AccessPermissions');
        }
    }
?>
<!DOCTYPE html>
<html lang="en" class="dark:bg-neutral-800 dark:text-white">
    <head>
        <title><?php echo __('Panel:SignIn'); ?> - <?php echo __('General:Saturn'); ?> <?php echo __('Panel:Panel'); ?></title>
        <?php
            include_once __DIR__.'/../../../common/panel/vendors.php';
            include_once __DIR__.'/../../../common/panel/theme.php';
        ?>

    </head>
    <body>
        <header class="bg-white shadow dark:bg-neutral-900">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel" class="text-<?php echo THEME_PANEL_COLOUR; ?>-900 dark:text-white"><?php echo __('General:Saturn'); ?> <?php echo __('Panel:Panel'); ?></a>
                </h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="<?php echo __('General:Saturn'); ?>">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                            <?php echo __('Panel:SignIn_Message'); ?>
                        </h2>
                        <?php
                            if (isset($errorMsg)) {
                                echo alert('ERROR', $errorMsg);
                                unset($errorMsg);
                            } elseif (isset($successMsg)) {
                                echo alert('SUCCESS', $successMsg);
                                unset($successMsg);
                            }
                        ?>
                    </div>
                    <form class="mt-8 space-y-6" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <input type="hidden" name="remember" value="true">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="username" class="sr-only"><?php echo __('Panel:UsernameEmail'); ?></label>
                                <input id="username" name="username" type="text" autocomplete="username" required class="dark:bg-neutral-700 dark:text-white appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-neutral-900 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm" placeholder="<?php echo __('Panel:UsernameEmail'); ?>">
                            </div>
                            <div>
                                <label for="password" class="sr-only"><?php echo __('Panel:Password'); ?></label>
                                <input id="password" name="password" type="password" autocomplete="current-password" required class="dark:bg-neutral-700 dark:text-white appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-neutral-900 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm" placeholder="<?php echo __('Panel:Password'); ?>">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-sm">
                                <a href="forgot-password" class="font-medium text-<?php echo THEME_PANEL_COLOUR; ?>-700 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-500 dark:text-gray-300 dark:hover:text-white transition duration-200">
                                    <?php echo __('Panel:ForgotPassword'); ?>
                                </a>
                            </div><?php if (CONFIG_REGISTRATION_ENABLED) { ?>
                            <div class="text-sm">
                                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/account/register" class="font-medium text-<?php echo THEME_PANEL_COLOUR; ?>-700 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-500 dark:text-gray-300 dark:hover:text-white transition duration-200">
                                    <?php echo __('Panel:Register'); ?>
                                </a>
                            </div><?php } ?>
                        </div>

                        <div>
                            <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-white bg-<?php echo THEME_PANEL_COLOUR; ?>-100 dark:bg-neutral-700 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 dark:hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-lock" aria-hidden="true"></i>
                                </span>
                                <?php echo __('Panel:SignIn'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>