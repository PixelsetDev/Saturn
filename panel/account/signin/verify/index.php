<?php
    ob_start();
    session_start();

    include_once __DIR__.'/../../../../common/global_public.php';

    if(!isset($_GET['type']) || !isset($_GET['username'])) {
        header('Location: /panel/account/signin/?signedout=true');
    }

    require_once __DIR__.'/../../../../common/processes/database/get/user.php';

    if (isset($_POST['verify'])) {
        if (!empty($_POST['code'])) {
            require_once __DIR__.'/../../../../common/processes/database/update/user.php';
            $username = checkInput('DEFAULT', $_GET['username']);
            $id = get_user_id($username);
            $dbCode = get_user_auth_code($id);
            update_user_auth_code($id, '');

            if ($_POST['code'] == $dbCode) {
                if (isset($_GET['type'])) {
                    if ($_GET['type'] == '1') {
                        $sql = 'SELECT * FROM `'.DATABASE_PREFIX."users` WHERE `email` = '".$username."' OR `username` = '".$username."';";
                        $rs = mysqli_query($conn, $sql);
                        $getUserRow = mysqli_fetch_assoc($rs);

                        $session['id'] = $getUserRow['id'];
                        $session['username'] = $getUserRow['username'];
                        $session['role_id'] = $getUserRow['role_id'];
                        unset($getUserRow);

                        $newKey = generate_uka_key();
                        update_user_key($session['id'], $newKey);
                        $session['user_key'] = $newKey;

                        $_SESSION = $session;
                        $ip = hash_ip($_SERVER['REMOTE_ADDR']);
                        update_user_last_login_ip($id, $ip);
                        header('location:'.CONFIG_INSTALL_URL.'/panel/account/signin/?signedout=verified');
                    } elseif ($_GET['type'] == '2') {
                        $_SESSION['2FA_verified'] = true;

                        $newKey = generate_uka_key();
                        update_user_key($_SESSION['id'], $newKey);
                        $_SESSION['user_key'] = $newKey;
                        header('location:'.CONFIG_INSTALL_URL.'/panel/dashboard');
                    }
                }
            } else {
                log_file('SATURN][SECURITY', __('Account_FailedLogin_1').' '.$username.' '.__('Account_FailedLogin_2').' '.hash_ip($_SERVER['REMOTE_ADDR']));
                $errorMsg = __('Error:CodeNotMatch');
            }
        }
    } else {
        $username = checkInput('DEFAULT', $_GET['username']);
        $id = get_user_id($username);

        try {
            $code = random_int(100000, 999999);
        } catch (Exception $e) {
            echo 'Exception: '.$e;
            exit;
        }
        require_once __DIR__.'/../../../../common/processes/database/update/user.php';
        $email = get_user_email($id);
        send_email($email, CONFIG_SITE_NAME.' - '.__('Panel:VerificationCode'), __('Panel:VerificationCode_Message_1').' "'.$code.'". '.__('Panel:VerificationCode_Message_2'));
        if (isset($_GET['type'])) {
            if ($_GET['type'] == '1') {
                $infoMsg = __('Panel:Verify_NewLocation').' '.__('Panel:Verify_EnterCode');
            } elseif ($_GET['type'] == '2') {
                $infoMsg = __('Panel:Verify_EnterCode');
            } else {
                $errorMsg = __('Error:Verify_Unknown');
                $infoMsg = __('Panel:Verify_EnterCode');
            }
        }
    }
    ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en" class="dark:bg-neutral-800 dark:text-white">
    <head>
        <title><?php echo __('Panel:Verify_User'); ?> - <?php echo __('General:Saturn').' '.__('Panel:Panel'); ?></title>
        <?php
        include_once __DIR__.'/../../../../common/panel/vendors.php';
        include_once __DIR__.'/../../../../common/panel/theme.php';
        ?>

    </head>
    <body>
        <header class="bg-white shadow dark:bg-neutral-900">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel" class="text-<?php echo THEME_PANEL_COLOUR; ?>-900 dark:text-white"><?php echo __('General:Saturn').' '.__('Panel:Panel'); ?></a>
                </h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="<?php echo __('General:Saturn'); ?>">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                            <?php
                                if (isset($_GET['type'])) {
                                    if ($_GET['type'] == '2') {
                                        echo __('Panel:2FA');
                                    } else {
                                        echo __('Panel:Verify_User');
                                    }
                                }
                            ?>
                        </h2>
                        <?php
                            if (isset($errorMsg)) {
                                echo alert('ERROR', $errorMsg);
                                log_error('ERROR', $errorMsg);
                                unset($errorMsg);
                            }
                            if (isset($infoMsg)) {
                                echo alert('INFO', $infoMsg);
                                unset($infoMsg);
                            }
                        ?>
                    </div>
                    <form class="mt-8 space-y-6" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>?type=<?php echo checkOutput('DEFAULT', $_GET['type']); ?>&username=<?php echo checkOutput('DEFAULT', $username); ?>" method="post">
                        <input type="hidden" name="remember" value="true">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="code" class="sr-only"><?php echo __('Panel:Verify_Code'); ?></label>
                                <input id="code" name="code" type="text" autocomplete="one-time-code" required class="dark:bg-neutral-700 dark:text-white appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 dark:border-neutral-900 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm" placeholder="<?php echo __('Panel:Verify_Code'); ?>">
                            </div>
                        </div>

                        <div>
                            <button type="submit" name="verify" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 dark:bg-neutral-700 dark:hover:bg-neutral-600 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 dark:text-gray-300 dark:hover:text-white transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-lock" aria-hidden="true"></i>
                                </span>
                                <?php echo __('Panel:Verify'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>