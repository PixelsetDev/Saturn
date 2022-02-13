<?php
    include_once __DIR__.'/../../../common/global_public.php';
    if (CONFIG_REGISTRATION_ENABLED) {
        if (isset($_GET['error'])) {
            $errorMsg = $_GET['error'];
        } else {
            if (isset($_POST['verify'])) {
                if (!empty($_POST['verify_email'])) {
                    include_once __DIR__.'/../../../common/processes/database/get/user.php';
                    $email = checkInput('DEFAULT', $_POST['verify_email']);
                    if (get_user_email_exists($email)) {
                        $errorMsg = __('Error:EmailExists');
                        header('Location: log.php?error='.$errorMsg);
                        exit;
                    } else {
                        try {
                            $code = random_int(100000, 999999);
                        } catch (Exception $e) {
                            $errorMsg = __('Error:Code');
                            $code = ('Error:TryAgain');
                        }
                        $code = checkInput('DEFAULT', $code);
                        $hashCode = hash('SHA3-512', $code);
                        $message = __('Panel:VerificationCode_Message_1').' "'.$code.'". '.__('Panel:VerificationCode_Message_2');
                        send_email($email, __('Panel:VerificationCode'), $message);
                        $successMsg = __('Panel:VerificationCode_Email');
                    }
                } else {
                    $errorMsg = __('Error:EmailBlank');
                }
            } elseif (isset($_POST['confirm'])) {
                if (!empty($_POST['code'])) {
                    $hashCode = checkInput('DEFAULT', $_POST['c']);
                    $code = checkInput('DEFAULT', $_POST['code']);
                    $newHashCode = hash('SHA3-512', $code);
                    if ($hashCode != $newHashCode) {
                        $errorMsg = __('Error:CodeNotMatch');
                        header('Location: index.php?error='.$errorMsg);
                        exit;
                    }
                } else {
                    $errorMsg = __('Error:CodeBlank');
                    header('Location: index.php?error='.$errorMsg);
                    exit;
                }
            } elseif (isset($_POST['register'])) {
                include_once __DIR__.'/../../../common/processes/database/create/user.php';
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
                    $successMsg = __('Panel:PendingApproval');
                } else {
                    $errorMsg = __('Error:Error');
                    header('Location: index.php?error='.$errorMsg);
                    exit;
                }
            }
        } ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo __('Panel:Register'); ?> - <?php echo __('General:Saturn'); ?></title>
        <?php
        include_once __DIR__.'/../../../common/panel/vendors.php';
        include_once __DIR__.'/../../../common/panel/theme.php'; ?>

    </head>
    <body>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900"><a href="<?php echo CONFIG_INSTALL_URL; ?>/panel"><?php echo __('General:Saturn'); ?> <?php echo __('Panel:Panel'); ?></a></h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="<?php echo __('General:Saturn'); ?>">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                            <?php echo __('Panel:Register_Message'); ?> <?php echo CONFIG_SITE_NAME; ?>.
                        </h2>
                        <p class="mt-6 text-center text-md font-base text-gray-900">
                            <?php echo __('Panel:Register_AccountsApprove'); ?>
                        </p>
                        <?php
                            if (isset($errorMsg)) {
                                echo alert('ERROR', $errorMsg);
                                log_error('ERROR', $errorMsg);
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
                                <label for="code" class="sr-only">'.__('Panel:Code').'</label>
                                <input id="code" name="code" type="text" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-'.THEME_PANEL_COLOUR.'-500 focus:border-'.THEME_PANEL_COLOUR.'-500 focus:z-10 sm:text-sm" placeholder="'.__('Panel:VerificationCode').'">
                            </div>
                        </div>
        
                        <div>
                            <input id="c" name="c" type="text" required value="'.$hashCode.'" class="hidden" placeholder="c">
                            <input id="email" name="email" type="text" required value="'.checkOutput('DEFAULT', $_POST['verify_email']).'" class="hidden" placeholder="email">
                            <button type="submit" name="confirm" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-'.THEME_PANEL_COLOUR.'-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                '.__('Panel:Verify').'
                            </button>
                        </div>
                    </form>';
                            } elseif (isset($_POST['confirm'])) {
                                echo'<form class="mt-8 space-y-6" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">
                        <input type="hidden" name="remember" value="true">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="email_address" class="sr-only">'.__('Panel:EmailAddress').'</label>
                                <input id="email_address" name="email_address" type="email" value="'.checkOutput('DEFAULT', $_POST['email']).'" autocomplete="email" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-'.THEME_PANEL_COLOUR.'-500 focus:border-'.THEME_PANEL_COLOUR.'-500 focus:z-10 sm:text-sm" placeholder="'.__('Panel:EmailAddress').'">
                            </div>
                            <div class="flex w-full">
                                <div class="flex-grow">
                                    <label for="firstname" class="sr-only">'.__('Panel:FirstName').'</label>
                                    <input id="firstname" name="firstname" type="text" autocomplete="firstname" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-none focus:outline-none focus:ring-'.THEME_PANEL_COLOUR.'-500 focus:border-'.THEME_PANEL_COLOUR.'-500 focus:z-10 sm:text-sm" placeholder="'.__('Panel:FirstName').'">
                                </div>
                                <div class="flex-grow">
                                    <label for="lastname" class="sr-only">'.__('Panel:LastName').'</label>
                                    <input id="lastname" name="lastname" type="text" autocomplete="lastname" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-none focus:outline-none focus:ring-'.THEME_PANEL_COLOUR.'-500 focus:border-'.THEME_PANEL_COLOUR.'-500 focus:z-10 sm:text-sm" placeholder="'.__('Panel:LastName').'">
                                </div>
                            </div>
                            <div>
                                <label for="password" class="sr-only">'.__('Panel:Password').'</label>
                                <input id="password" name="password" type="password" autocomplete="password" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-none focus:outline-none focus:ring-'.THEME_PANEL_COLOUR.'-500 focus:border-'.THEME_PANEL_COLOUR.'-500 focus:z-10 sm:text-sm" placeholder="'.__('Panel:Password').'">
                            </div>
                            <div>
                                <label for="organisation" class="sr-only">'.__('Panel:Organisation').'</label>
                                <input id="organisation" name="organisation" type="text" autocomplete="organisation" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-'.THEME_PANEL_COLOUR.'-500 focus:border-'.THEME_PANEL_COLOUR.'-500 focus:z-10 sm:text-sm" placeholder="'.__('Panel:Organisation').' ('.__('General:Optional').')">
                            </div>
                        </div>
        
                        <div>
                            <button type="submit" name="register" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-'.THEME_PANEL_COLOUR.'-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-padlock"></i>
                                </span>
                                '.__('Panel:RequestAccount').'
                            </button>
                        </div>
                    </form>';
                            } else {
                                echo'<form class="mt-8 space-y-6" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">
                        <input type="hidden" name="remember" value="true">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="verify_email" class="sr-only">'.__('Panel:EmailAddress').'</label>
                                <input id="verify_email" name="verify_email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-'.THEME_PANEL_COLOUR.'-500 focus:border-'.THEME_PANEL_COLOUR.'-500 focus:z-10 sm:text-sm" placeholder="'.__('Panel:EmailAddress').'">
                            </div>
                        </div>
        
                        <div>
                            <button type="submit" name="verify" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-'.THEME_PANEL_COLOUR.'-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                '.__('Panel:Verify').'
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
            <title><?php echo __('Panel:Register'); ?> - <?php echo __('General:Saturn'); ?></title>
            <?php
            include_once __DIR__.'/../../../common/panel/vendors.php';
            include_once __DIR__.'/../../../common/panel/theme.php';
            ?>

        </head>
        <body>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900"><a href="<?php echo CONFIG_INSTALL_URL; ?>/panel"><?php echo __('General:Saturn'); ?> <?php echo __('Panel:Panel'); ?></a></h1>
            </div>
        </header>
        <main>
            <div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-md w-full space-y-8">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="<?php echo __('General:Saturn'); ?>">
                        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                            <?php echo __('Panel:Register_Message'); ?> <?php echo CONFIG_SITE_NAME; ?>.
                        </h2>
                        <p class="mt-6 text-center text-md font-base text-gray-900">
                            <?php echo __('Panel:Register_AccountsApprove'); ?>
                        </p>
                        <?php
                        echo alert('ERROR', __('Panel:Register_Closed'));

                        if (isset($errorMsg)) {
                            echo alert('ERROR', $errorMsg);
                            log_error('ERROR', $errorMsg);
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