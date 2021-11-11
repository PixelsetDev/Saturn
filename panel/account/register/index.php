<?php
    include_once __DIR__.'/../../../assets/common/global_public.php';
    if (CONFIG_REGISTRATION_ENABLED) {
        if (isset($_GET['error'])) {
            $errorMsg = $_GET['error'];
        } else {
            if (isset($_POST['verify'])) {
                if (!empty($_POST['verify_email'])) {
                    include_once __DIR__.'/../../../assets/common/processes/database/get/user.php';
                    $email = checkInput('DEFAULT', $_POST['verify_email']);
                    if (get_user_email_exists($email)) {
                        $errorMsg = 'A user with this email address already exists.';
                        header('Location: log.php?error='.$errorMsg);
                        exit;
                    } else {
                        try {
                            $code = random_int(100000, 999999);
                        } catch (Exception $e) {
                            $errorMsg = 'An error occurred whilst generating a code. Please try again later.';
                            $code = '[ERROR] Please try again.';
                        }
                        $code = checkInput('DEFAULT', $code);
                        $hashCode = hash('SHA3-512', $code);
                        $message = 'Your Saturn Verification Code is: "'.$code.'". Please enter this code into Saturn to proceed.';
                        send_email($email, 'Saturn Verification Code', $message);
                        $successMsg = 'Please check your email and do not exit this page.';
                    }
                } else {
                    $errorMsg = 'Email address must not be blank.';
                }
            } elseif (isset($_POST['confirm'])) {
                if (!empty($_POST['code'])) {
                    $hashCode = checkInput('DEFAULT', $_POST['c']);
                    $code = checkInput('DEFAULT', $_POST['code']);
                    $newHashCode = hash('SHA3-512', $code);
                    if ($hashCode != $newHashCode) {
                        $errorMsg = 'The verification code that you provided does not match the code that we sent.';
                        header('Location: index.php?error='.$errorMsg);
                        exit;
                    }
                } else {
                    $errorMsg = 'Code must not be blank.';
                    header('Location: index.php?error='.$errorMsg);
                    exit;
                }
            } elseif (isset($_POST['register'])) {
                include_once __DIR__.'/../../../assets/common/processes/database/create/user.php';
                $email = $_POST['email_address'];
                $email = checkInput('DEFAULT', $email);
                $firstname = $_POST['firstname'];
                $firstname = checkInput('DEFAULT', $firstname);
                $lastname = $_POST['lastname'];
                $lastname = checkInput('DEFAULT', $lastname);
                $password = $_POST['password'];
                $password = checkInput('DEFAULT', $password);
                $password = password_hash($password, PASSWORD_DEFAULT);
                $organisation = $_POST['organisation'];
                $organisation = checkInput('DEFAULT', $organisation);
                if (create_user($email, $firstname, $lastname, $password, $organisation)) {
                    $successMsg = 'Your Saturn account is now pending approval, we\'ll send you an email when you\'re ready to get started.';
                } else {
                    $errorMsg = 'Sorry there was an error, please try again later.';
                    header('Location: index.php?error='.$errorMsg);
                    exit;
                }
            }
        } ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Register - Saturn Panel</title>
        <?php
        include_once __DIR__.'/../../../assets/common/panel/vendors.php';
        include_once __DIR__.'/../../../assets/common/panel/theme.php'; ?>

    </head>
    <body>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900"><a href="<?php echo CONFIG_INSTALL_URL; ?>/panel">Saturn Panel</a></h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="Saturn">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                            Register to Join <?php echo CONFIG_SITE_NAME; ?>.
                        </h2>
                        <p class="mt-6 text-center text-md font-base text-gray-900">
                            Saturn accounts must be approved by the website owner before you can access them.
                        </p>
                        <?php
                            if (isset($errorMsg)) {
                                echo alert('ERROR', $errorMsg);
                                unset($errorMsg);
                            } elseif (isset($successMsg)) {
                                echo alert('SUCCESS', $successMsg);
                                unset($successMsg);
                            } ?>
                    </div>
                    <?php if (isset($_POST['verify'])) {
                                echo'<form class="mt-8 space-y-6" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">
                        <input type="hidden" name="remember" value="true">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="code" class="sr-only">Code</label>
                                <input id="code" name="code" type="text" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Verification Code">
                            </div>
                        </div>
        
                        <div>
                            <input id="c" name="c" type="text" required value="'.$hashCode.'" class="hidden" placeholder="c">
                            <input id="email" name="email" type="text" required value="'.checkOutput('DEFAULT', $_POST['verify_email']).'" class="hidden" placeholder="email">
                            <button type="submit" name="confirm" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                Verify Code
                            </button>
                        </div>
                    </form>';
                            } elseif (isset($_POST['confirm'])) {
                                echo'<form class="mt-8 space-y-6" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">
                        <input type="hidden" name="remember" value="true">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="email_address" class="sr-only">Email Address</label>
                                <input id="email_address" name="email_address" type="email" value="'.checkOutput('DEFAULT', $_POST['email']).'" autocomplete="email" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                            </div>
                            <div class="flex w-full">
                                <div class="flex-grow">
                                    <label for="firstname" class="sr-only">First Name</label>
                                    <input id="firstname" name="firstname" type="text" autocomplete="firstname" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="First Name">
                                </div>
                                <div class="flex-grow">
                                    <label for="lastname" class="sr-only">Last Name</label>
                                    <input id="lastname" name="lastname" type="text" autocomplete="lastname" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="First Name">
                                </div>
                            </div>
                            <div>
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" name="password" type="password" autocomplete="password" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                            </div>
                            <div>
                                <label for="organisation" class="sr-only">Organisation</label>
                                <input id="organisation" name="organisation" type="text" autocomplete="organisation" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Organisation (Optional)">
                            </div>
                        </div>
        
                        <div>
                            <button type="submit" name="register" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-padlock"></i>
                                </span>
                                Request Account
                            </button>
                        </div>
                    </form>';
                            } else {
                                echo'<form class="mt-8 space-y-6" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">
                        <input type="hidden" name="remember" value="true">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="verify_email" class="sr-only">Email Address</label>
                                <input id="verify_email" name="verify_email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                            </div>
                        </div>
        
                        <div>
                            <button type="submit" name="verify" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                Verify Email
                            </button>
                        </div>
                    </form>';
                            } ?>
                </div>
            </div>
        </main>
    </body>
</html>
<?php
    } else { ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Register - Saturn Panel</title>
            <?php
            include_once __DIR__.'/../../../assets/common/panel/vendors.php';
            include_once __DIR__.'/../../../assets/common/panel/theme.php';
            ?>

        </head>
        <body>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900"><a href="<?php echo CONFIG_INSTALL_URL; ?>/panel">Saturn Panel</a></h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="Saturn">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                            Register to Join <?php echo CONFIG_SITE_NAME; ?>.
                        </h2>
                        <p class="mt-6 text-center text-md font-base text-gray-900">
                            Saturn accounts must be approved by the website owner before you can access them.
                        </p>
                        <?php
                        echo alert('ERROR', 'Sorry, registration is currently closed.');

                        if (isset($errorMsg)) {
                            echo alert('ERROR', $errorMsg);
                            unset($errorMsg);
                        } elseif (isset($successMsg)) {
                            echo alert('SUCCESS', $successMsg);
                            unset($successMsg);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
<?php } ?>