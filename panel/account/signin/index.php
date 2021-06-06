<?php
    session_start();

    include_once(__DIR__ . '/../../../assets/common/global_public.php');

    if(isset($_POST['login']) || isset($_GET['login'])) {
        if(!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $username = checkInput('DEFAULT', $username);
            $password = checkInput('DEFAULT', $password);

            $sql = "SELECT * FROM `".DATABASE_PREFIX."users` WHERE `email` = '".$username."' OR `username` = '".$username."';";
            $rs = mysqli_query($conn,$sql);
            $getNumRows = mysqli_num_rows($rs);
            $getUserRow = mysqli_fetch_assoc($rs);

            if (password_verify($password, $getUserRow['password'])) {
                unset($password);
                if($getUserRow['role_id'] == '1') {
                    $errorMsg = "Your account has not been approved by a site administrator yet. We'll send you an email when we're ready for you to sign in.";
                } else if($getUserRow['role_id'] == '0') {
                    $errorMsg = "Your account has been restricted. If you require access, please contact your administrator.";
                } else {
                    require_once __DIR__ . '/../../../assets/common/processes/database/get/user.php';
                    require_once __DIR__ . '/../../../assets/common/processes/database/update/user.php';
                    if(get_user_last_login_ip($getUserRow['id']) != hash_ip($_SERVER['REMOTE_ADDR'])) {
                        echo '<meta http-equiv="refresh" content="0; url='.CONFIG_INSTALL_URL.'/panel/account/signin/verify/?username='.$getUserRow['username'].'">';
                        exit;
                    } else {
                        $session['id']=$getUserRow['id'];$session['username']=$getUserRow['username'];$session['role_id']=$getUserRow['role_id'];
                        unset($getUserRow);

                        $newKey = generate_uka_key();
                        update_user_key($session['id'], $newKey);
                        $session['user_key'] = $newKey;

                        $_SESSION = $session;
                        echo '<meta http-equiv="refresh" content="0; url='.CONFIG_INSTALL_URL.'/panel/dashboard">';
                        exit;
                    }
                }
                unset($getUserRow['password']);
            }
            else {
                unset($password, $row, $rs, $sql);
                $errorMsg = "Username or Password is incorrect.";
            }
        }
    }

    if(isset($_GET['signedout'])) {
        if($_GET['signedout'] == 'true') {$errorMsg = "You need to sign in to access this area.";}
        if($_GET['signedout'] == 'role') {$errorMsg = "You need to sign in to access this area.<br>Error GSS1";}
        if($_GET['signedout'] == 'key') {$errorMsg = "You need to sign in to access this area.<br>Error GSS2";}
        if($_GET['signedout'] == 'verified') {$successMsg = "Your IP has been verified. You may now sign in to Saturn.";}
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign in - Saturn Panel</title>
        <?php
            include_once(__DIR__ . '/../../../assets/common/panel/vendors.php');
            include_once(__DIR__ . '/../../../assets/common/panel/theme.php');
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
                            Sign in to your account.
                        </h2>
                        <?php
                        if(isset($errorMsg)){
                            echo '<br>
                                    <div class="duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                                        <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                            <h6 class="mb-2 font-semibold leading-5">'.$errorMsg.'</h6>
                                        </div>
                                    </div>';
                            unset($errorMsg);
                        } else if(isset($successMsg)){
                                echo '<br>
                                    <div class="duration-300 transform bg-green-100 border-l-4 border-green-500 hover:-translate-y-2">
                                        <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                            <h6 class="mb-2 font-semibold leading-5">'.$successMsg.'</h6>
                                        </div>
                                    </div>';
                                unset($successMsg);
                            }
                        ?>
                    </div>
                    <form class="mt-8 space-y-6" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <input type="hidden" name="remember" value="true">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="username" class="sr-only">Username or Email Address</label>
                                <input id="username" name="username" type="username" autocomplete="username" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Username or Email address">
                            </div>
                            <div>
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <!--<div class="flex items-center">
                                <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                                    Remember me
                                </label>
                            </div>-->

                            <div class="text-sm">
                                <a href="forgot-password" class="font-medium text-blue-700 hover:text-blue-500">
                                    Forgot your password?
                                </a>
                            </div>
                        </div>

                        <div>
                            <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-lock"></i>
                                </span>
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>