<?php
    include_once __DIR__.'/../../../../common/global_public.php';

    session_start();

    $status = 0;

    if (isset($_POST['username'])) {
        if (!empty($_POST['username'])) {
            $username = trim($_POST['username']);
            $username = checkInput('ALL', $username);

            $sql = 'SELECT email, id, role_id FROM `'.DATABASE_PREFIX."users` WHERE `email` = '".$username."' OR `username` = '".$username."';";
            $rs = mysqli_query($conn, $sql);
            $getNumRows = mysqli_num_rows($rs);

            if ($getNumRows == 1) {
                $userData = mysqli_fetch_assoc($rs);
                if ($userData['role_id'] == '1') {
                    $errorMsg = __('Error:AccountNotApproved');
                } elseif ($userData['role_id'] == '0') {
                    $errorMsg = __('Error:Account_Deleted').' "'.CONFIG_EMAIL_ADMIN.'". ';
                } else {
                    try {
                        $code = random_int(100000, 999999);
                    } catch (Exception $e) {
                        errorHandlerError($e, __('Error:RandomInteger'));
                    }
                    $sql = 'UPDATE `'.DATABASE_PREFIX."users` SET `auth_code` = '$code' WHERE `email` = '".$username."' OR `username` = '".$username."';";
                    $rs = mysqli_query($conn, $sql);

                    $email = $userData['email'];
                    $user_id = $userData['id'];
                    $page = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    send_email($email, 'Saturn Password Reset', 'Your Saturn password reset code is: '.$code.'<br><br>Please enter this code into Saturn or <a href="'.$page.'?code='.$code.'" class="underline">click here to continue</a>.');
                    $infoMsg = 'We\'ve sent you an email to confirm the information you have provided. Please click the link in your email to continue.';

                    $status = 0;
                }
            } else {
                $errorMsg = __('Error:UnknownAccount');
                $status = 0;
            }
        } else {
            $errorMsg = __('Error:Reset_UsernameRequired');
            $status = 0;
        }
    }

    if (isset($_GET['code'])) {
        $code = trim($_GET['code']);
        $code = checkInput('DEFAULT', $code);

        $sql = 'SELECT id FROM `'.DATABASE_PREFIX."users` WHERE `auth_code` = '".$code."';";
        $rs = mysqli_query($conn, $sql);
        $getNumRows = mysqli_num_rows($rs);

        if ($getNumRows == 1) {
            $status = 1;
        } else {
            $sql = 'UPDATE `'.DATABASE_PREFIX."users` SET `auth_code` = '' WHERE `id` = '".$userData['id']."';";
            $rs = mysqli_query($conn, $sql);

            $errorMsg = __('Error:CodeNotMatch');
            $status = 0;
        }
    }

    if (isset($_POST['securitycode'])) {
        $code = trim($_POST['securitycode']);
        $code = checkInput('DEFAULT', $code);

        $sql = 'SELECT id FROM `'.DATABASE_PREFIX."users` WHERE `auth_code` = '".$code."';";
        $rs = mysqli_query($conn, $sql);
        $getNumRows = mysqli_num_rows($rs);

        if ($getNumRows == 1) {
            if (isset($_POST['password']) && isset($_POST['confirmpassword'])) {
                if ($_POST['password'] == $_POST['confirmpassword']) {
                    $userData = mysqli_fetch_assoc($rs);

                    $password = trim($_POST['password']);
                    $password = checkInput('DEFAULT', $password);
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $sql = 'UPDATE `'.DATABASE_PREFIX."users` SET `password` = '$hashedPassword' WHERE `id` = '".$userData['id']."';";
                    $rs = mysqli_query($conn, $sql);

                    $sql = 'UPDATE `'.DATABASE_PREFIX."users` SET `auth_code` = '' WHERE `id` = '".$userData['id']."';";
                    $rs = mysqli_query($conn, $sql);

                    $successMsg = 'Password changed successfully.<br>You can now log in using your new credentials.';
                    $status = 2;
                } else {
                    $errorMsg = __('Error:Reset_PasswordNotMatch');
                    $status = 0;
                }
            } else {
                $errorMsg = __('Error:Reset_PasswordEmpty');
            }
        } else {
            $sql = 'UPDATE `'.DATABASE_PREFIX."users` SET `auth_code` = '' WHERE `id` = '".$userData['id']."';";
            $rs = mysqli_query($conn, $sql);

            $errorMsg = __('Error:UnknownAccount');
            $status = 0;
        }
    }
?>
<!DOCTYPE html>
<html lang="en" class="dark:bg-neutral-800 dark:text-white">
    <head>
        <title>Forgot Password - Saturn Panel</title>
        <?php
        include_once __DIR__.'/../../../../common/panel/vendors.php';
        include_once __DIR__.'/../../../../common/panel/theme.php';
        ?>

    </head>
    <body>
        <?php
        include_once __DIR__.'/../../../../common/panel/vendors.php';
        ?>
        <header class="bg-white shadow dark:bg-neutral-900">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel" class="text-<?php echo THEME_PANEL_COLOUR; ?>-900 dark:text-white">Saturn Panel</a>
                </h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="Saturn">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                            Forgot Password.
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
                        if (isset($successMsg)) {
                            echo alert('SUCCESS', $successMsg);
                            unset($successMsg);
                        }
                        ?>
                    </div>
                    <form class="mt-8 space-y-6" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
<?php if ($status == 0) { ?>
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="username" class="sr-only">Email address or Username</label>
                                <input id="username" name="username" type="text" autocomplete="username" required class="dark:bg-neutral-700 dark:text-white appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 dark:border-neutral-900 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm" placeholder="Email Address or Username">
                            </div>
                        </div>
                        <div>
                            <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 dark:bg-neutral-700 dark:hover:bg-neutral-600 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 dark:text-gray-300 dark:hover:text-white transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-unlock" aria-hidden="true"></i>
                                </span>
                                Reset Password
                            </button>
                        </div>
<?php } elseif ($status == 1) { ?>
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="securitycode" class="text-xs">Security Code</label><br>
                                <input id="securitycode" name="securitycode" type="password" autocomplete="code" value="<?php echo $code; ?>" required class="dark:bg-neutral-700 dark:text-white appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 dark:border-neutral-900 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm" placeholder="Security Code">
                            </div>
                        </div>
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" name="password" type="password" autocomplete="password" required class="dark:bg-neutral-700 dark:text-white appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 dark:border-neutral-900 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm" placeholder="Password">
                            </div>
                            <div>
                                <label for="confirmpassword" class="sr-only">Confirm Password</label>
                                <input id="confirmpassword" name="confirmpassword" type="password" autocomplete="password" required class="dark:bg-neutral-700 dark:text-white appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 dark:border-neutral-900 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div>
                            <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 dark:bg-neutral-700 dark:hover:bg-neutral-600 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 dark:text-gray-300 dark:hover:text-white transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-unlock" aria-hidden="true"></i>
                                </span>
                                Reset Password
                            </button>
                        </div>
<?php } elseif ($status == 2) { ?>
                        <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/account/signin" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 dark:bg-neutral-700 dark:hover:bg-neutral-600 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 dark:text-gray-300 dark:hover:text-white transition-all duration-200">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-lock" aria-hidden="true"></i>
                            </span>
                            Sign in
                        </a>
<?php
    } else {
        echo alert('ERROR', __('Error:Unknown'));
        log_error('ERROR', __('Error:Reset_Unknown'));
    }
?>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>