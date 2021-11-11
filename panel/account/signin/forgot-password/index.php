<?php
    include_once __DIR__.'/../../../../assets/common/global_public.php';

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
                    $errorMsg = "Your account has not been approved by a site administrator yet. We'll send you an email when we're ready for you to sign in.";
                } elseif ($userData['role_id'] == '0') {
                    $errorMsg = 'Your account has been deleted. If you require access, please contact your site administrator by emailing "'.CONFIG_EMAIL_ADMIN.'", thank you.';
                } else {
                    $code = random_int(100000, 999999);
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
                $errorMsg = 'Sorry, we were unable to determine what account the data you entered belongs to. Please try a different method of authentication.';
                $status = 0;
            }
        } else {
            $errorMsg = 'Please enter a username or email address.';
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

            $errorMsg = 'The code you provided does not match our records. For security purposes we have de-validated your security code, please generate a new one by completing the form again.';
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

                    echo $userData['id'];

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
                    $errorMsg = 'The password and confirmed password provided does not match. You can try again by clicking the link in your email.';
                    $status = 0;
                }
            } else {
                $errorMsg = 'You did not enter a password and confirmed password. You can try again by clicking the link in your email.';
            }
        } else {
            $sql = 'UPDATE `'.DATABASE_PREFIX."users` SET `auth_code` = '' WHERE `id` = '".$userData['id']."';";
            $rs = mysqli_query($conn, $sql);

            $errorMsg = 'Sorry, we were unable to determine what account the data you entered belongs to. For security purposes we have de-validated your security code, please generate a new one by completing the form again.';
            $status = 0;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Forgot Password - Saturn Panel</title>
        <?php
        include_once __DIR__.'/../../../../assets/common/panel/vendors.php';
        include_once __DIR__.'/../../../../assets/common/panel/theme.php';
        ?>

    </head>
    <body>
        <?php
        include_once __DIR__.'/../../../../assets/common/panel/vendors.php';
        ?>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel" class="text-<?php echo THEME_PANEL_COLOUR; ?>-900">Saturn Panel</a>
                </h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="Saturn">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                            Forgot Password.
                        </h2>
                        <?php
                        if (isset($errorMsg)) {
                            echo alert('ERROR', $errorMsg);
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
                                <input id="username" name="username" type="username" autocomplete="username" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email Address or Username">
                            </div>
                        </div>
                        <div>
                            <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
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
                                <input id="securitycode" name="securitycode" type="password" autocomplete="code" value="<?php echo $code; ?>" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Security Code">
                            </div>
                        </div>
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" name="password" type="password" autocomplete="password" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                            </div>
                            <div>
                                <label for="confirmpassword" class="sr-only">Confirm Password</label>
                                <input id="confirmpassword" name="confirmpassword" type="password" autocomplete="password" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div>
                            <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-unlock" aria-hidden="true"></i>
                                </span>
                                Reset Password
                            </button>
                        </div>
<?php } elseif ($status == 2) { ?>
                        <a href="'.CONFIG_INSTALL_URL.'/panel/account/signin" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-lock" aria-hidden="true"></i>
                            </span>
                            Sign in
                        </a>
<?php
    } else {
        echo alert('ERROR', 'An error has occurred, please try again later.');
    }
?>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>