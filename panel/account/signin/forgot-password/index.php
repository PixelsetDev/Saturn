<?php
    include_once(__DIR__ . '/../../../../assets/common/global_public.php');

    session_start();

    $done = false;

    if(isset($_POST['username'])) {
        if(!empty($_POST['username'])) {
            $username = trim($_POST['username']);
            $username = checkInput('ALL', $username);

            $sql = "SELECT email, id, role_id FROM `".DATABASE_PREFIX."users` WHERE `email` = '".$username."' OR `username` = '".$username."';";
            $rs = mysqli_query($conn,$sql);
            $getNumRows = mysqli_num_rows($rs);

            if($getNumRows == 1) {
                $getUserRow = mysqli_fetch_assoc($rs);
                if($getUserRow['role_id'] == '1') {
                    $errorMsg = "Your account has not been approved by a site administrator yet. We'll send you an email when we're ready for you to sign in.";
                } else if($getUserRow['role_id'] == '0') {
                    $errorMsg = "Your account has been deleted. If you require access, please contact your administrator.";
                } else {
                    $code = random_int(100000,999999);
                    $sql = "UPDATE `".DATABASE_PREFIX."users` SET `auth_code` = '$code' WHERE `email` = '".$username."' OR `username` = '".$username."';";
                    $rs = mysqli_query($conn,$sql);

                    $email = $getUserRow['email'];
                    $user_id = $getUserRow['id'];
                    $code = checksum_generate($code);
                    $page = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    send_email($email, 'Saturn Password Reset', '<a href="'.$page.'?id='.$user_id.'&code='.$code.'">'.$page.'?id='.$user_id.'&code='.$code.'</a>');
                    $infoMsg = "Please click on the link sent to your email to continue.";
                }
            }
            else {
                $errorMsg = "Sorry, we couldn't find an account that matched the information you provided.";
            }
        } else {
            $errorMsg = 'Username cannot be empty.';
        }
    }

    if(isset($_GET['code'])) {
        if(!empty($_GET['code'])) {
            $userCode = trim($_GET['code']);
            $userCode = checkInput('DEFAULT', $userCode);
            $user_id = trim($_GET['id']);
            $user_id = checkInput('DEFAULT', $user_id);

            $sql = "SELECT auth_code FROM `" . DATABASE_PREFIX . "users` WHERE `id` = '" . $user_id . "';";
            $rs = mysqli_query($conn,$sql);
            $getUserRow = mysqli_fetch_assoc($rs);
            $getNumRows = mysqli_num_rows($rs);

            if($getNumRows == 1) {
                $serverCode = $getUserRow['auth_code'];
                if (checksum_validate($serverCode, $userCode)) {
                    $infoMsg = "Please enter your new password.";
                    $verified = true;
                } else {
                    $errorMsg = "Password reset code does not match.";
                }
            } else {
                $errorMsg = "Password reset code does not match.";
            }
        } else {
            $errorMsg = "Invalid Password Reset Code.";
        }
    }

    if(isset($_POST['password'])) {
        if (!empty($_POST['password']) && !empty($_POST['confirmpassword'])) {
            $password = trim($_POST['password']);
            $password = checkInput('DEFAULT', $password);
            $confirmPassword = trim($_POST['confirmpassword']);
            $confirmPassword = checkInput('DEFAULT', $confirmPassword);

            if($password == $confirmPassword) {
                $id = $_POST['user_id'];
                $id = checkInput('DEFAULT', $id); echo $id;
                $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

                $sql = "UPDATE `".DATABASE_PREFIX."users` SET `password` = '$hashedPassword' WHERE `id` = '".$id."';";
                $rs = mysqli_query($conn,$sql);

                $successMsg = "Password changed successfully.<br>You can now log in using your new credentials.";
                $done = true;
            } else {
                $errorMsg = "Password and Confirm Password fields do not match.";
            }
        } else {
            $errorMsg = "New password not entered.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Forgot Password - Saturn Panel</title>
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
                            Forgot Password.
                        </h2>
                        <?php
                            if(isset($errorMsg)){
                                alert('ERROR', $errorMsg);
                                unset($errorMsg);
                            }
                            if(isset($infoMsg)){
                                alert('INFO', $infoMsg);
                                unset($infoMsg);
                            }
                            if(isset($successMsg)){
                                alert('SUCCESS', $successMsg);
                                unset($successMsg);
                            }
                        ?>
                    </div>
                    <form class="mt-8 space-y-6" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <?php if($done) {
                            if (!isset($verified)) {
                                echo '<div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="username" class="sr-only">Email address or Username</label>
                                <input id="username" name="username" type="username" autocomplete="username" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email Address or Username">
                            </div>
                        </div>';
                            } else {
                                echo '<textarea id="user_id" name="user_id" css="display:none;">'.checkInput('DEFAULT', $_GET['id']).'</textarea>
                        <div class="rounded-t-md shadow-sm -space-y-px">
                            <div>
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" name="password" type="password" autocomplete="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                            </div>
                            <div>
                                <label for="confirmpassword" class="sr-only">Confirm Password</label>
                                <input id="confirmpassword" name="confirmpassword" type="password" autocomplete="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Confirm Password">
                            </div>
                        </div>';
                            }

                        echo '<div>
                            <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-unlock"></i>
                                </span>
                                Reset Password
                            </button>
                        </div>';
                        } else {
                            echo '<a href="'.CONFIG_INSTALL_URL.'/panel/account/signin" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-lock"></i>
                                </span>
                                Sign in
                            </a>';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>
