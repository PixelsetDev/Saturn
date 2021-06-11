<?php
    include_once(__DIR__ . '/../../../../assets/common/global_public.php');

    session_start();
    require_once(__DIR__ . '/../../../../assets/common/processes/database/get/user.php');

    if(isset($_POST['verify'])) {
        if(!empty($_POST['code'])) {
            require_once(__DIR__ . '/../../../../assets/common/processes/database/update/user.php');
            $username = checkInput('DEFAULT', $_GET['username']);
            $id = get_user_id($username);
            $dbCode = get_user_auth_code($id);
            update_user_auth_code($id, '');

            if ($_POST['code'] == $dbCode) {
                $sql = "SELECT * FROM `".DATABASE_PREFIX."users` WHERE `email` = '".$username."' OR `username` = '".$username."';";
                $rs = mysqli_query($conn,$sql);
                $getUserRow = mysqli_fetch_assoc($rs);

                $session['id']=$getUserRow['id'];$session['username']=$getUserRow['username'];$session['role_id']=$getUserRow['role_id'];
                unset($getUserRow);

                $newKey = generate_uka_key();
                update_user_key($session['id'], $newKey);
                $session['user_key'] = $newKey;

                $_SESSION = $session;
                $ip = hash_ip($_SERVER['REMOTE_ADDR']);
                update_user_last_login_ip($id, $ip);
                header('location:'.CONFIG_INSTALL_URL.'/panel/account/signin/?signedout=verified');
            } else {
                log_file('SATURN][SECURITY','Failed login verification attempt by user to account '.$username.' with IP Hash: '.hash_ip($_SERVER['REMOTE_ADDR']));
                $errorMsg = 'Code does not match. <a href="'.$_SERVER['PHP_SELF'].'?username='.$username.'" class="text-red-500 hover:text-red-400">Click here to re-send verification code</a>.';
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
        require_once(__DIR__ . '/../../../../assets/common/processes/database/update/user.php');
        update_user_auth_code($id, $code);
        $email = get_user_email($id);
        send_email($email, CONFIG_SITE_NAME.' - Saturn Verification Code', 'Your Saturn Verification Code is: "'.$code.'". Please enter this code into Saturn to proceed.');
        $errorMsg = 'We\'ve detected that you\'re attempting to sign in from a new location. To help us keep your account secure please enter the security code we\'ve sent to your email address in the box below.';
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>User Verification - Saturn Panel</title>
        <?php
        include_once(__DIR__ . '/../../../../assets/common/panel/vendors.php');
        include_once(__DIR__ . '/../../../../assets/common/panel/theme.php');
        ?>

    </head>
    <body>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900"><a href="<?php echo CONFIG_INSTALL_URL;?>/panel">Saturn Panel</a></h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="Saturn">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                            User Verification
                        </h2>
                        <?php
                            if(isset($errorMsg)){
                                alert('ERROR', $errorMsg);
                                unset($errorMsg);
                            }
                        ?>
                    </div>
                    <form class="mt-8 space-y-6" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>?username=<?php echo checkOutput('DEFAULT', $username);?>" method="post">
                        <input type="hidden" name="remember" value="true">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="code" class="sr-only">Verification Code</label>
                                <input id="code" name="code" type="code" autocomplete="one-time-code" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Verification Code">
                            </div>
                        </div>

                        <div>
                            <button type="submit" name="verify" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                            <i class="fas fa-lock" aria-hidden="true"></i>
                                        </span>
                                Verify
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>