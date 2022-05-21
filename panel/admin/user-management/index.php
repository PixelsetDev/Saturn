<?php
    session_start();
    ob_start();
    require_once __DIR__.'/../../../common/global_private.php';
    require_once __DIR__.'/../../../common/admin/global.php';
    ob_end_flush();

    if (isset($_POST['action'])) {
        $userid = checkInput('DEFAULT', $_POST['userid']);
        $role = checkInput('DEFAULT', $_POST['role']);
        if ($userid != $_SESSION['id']) {
            $prevRole = get_user_roleID($userid);
            $prevRoleName = get_user_role($userid);
            if ($prevRole != $role) {
                if (update_user_role_id($userid, $role)) {
                    $message = get_user_fullname($_SESSION['id']).' changed '.get_user_fullname($userid).'\'s role to '.get_user_role($userid).'.';
                    log_file('SATURN][User Management', $message);
                    create_notification($userid, __('Admin:UserManagement_RoleUpdated'), __('Admin:UserManagement_RoleUpdated_Message_1').' '.$prevRoleName.', '.__('Admin:UserManagement_RoleUpdated_Message_2').' '.get_user_role($userid).'.');
                    $successMsg = get_user_fullname($userid).__('Admin:UserManagement_RoleUpdated_Log').' '.get_user_role($userid).'.';
                } else {
                    $errorMsg = __('Error:UserManagement_Update');
                }
            }
        } else {
            $errorMsg = __('Error:UserManagement_Self').' <a href="'.CONFIG_INSTALL_URL.'/panel/team/profile/edit" class="text-black underline">'.__('General:ClickHere').'</a>.';
        }
    }

    if (isset($_POST['ban'])) {
        if ($_POST['ban_user_id'] == $_SESSION['id']) {
            $errorMsg = __('Error:UserManagement_Ban_Self');
        } else {
            if (ban_user(checkInput('DEFAULT', $_POST['ban_user_id']), checkInput('DEFAULT', $_POST['reason']))) {
                $successMsg = __('Admin:UserManagement_Banned');
            } else {
                $errorMsg = __('Error:UserManagement_Ban');
            }
        }
    }

    function displayUser($rs)
    {
        while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
            echo '<br>';
            foreach ($row as $value) {
                if (is_numeric($value)) {
                    $empty = false; ?>
                    <li class="h-12">
                                    <a href="<?php echo get_user_profile_link($value); ?>" class="relative inline-block float-left mr-4 z-30">
                                        <img class="z-10 inline-block object-cover w-12 h-12 rounded-full" src="<?php echo get_user_profilephoto($value); ?>" alt="<?php echo get_user_fullname($value); ?>">
                                        <span class="absolute bottom-0 right-0 inline-block w-3 h-3 bg-<?php echo get_activity_colour($value); ?>-600 border-2 border-gray-200 rounded-full"></span>
                                    </a>
                                    <div class="font-bold h-full" x-data="{ open: false }">
                                        <name class="self-start block"><?php echo get_user_fullname($value); ?></name>
                                        <button @click="open = true" class="font-normal hover:shadow-lg inline-flex items-center justify-center w-24 h-6 tracking-wide text-white transition duration-200 rounded bg-<?php echo THEME_PANEL_COLOUR; ?>-500 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-400 focus:shadow-outline focus:outline-none">
                                            <i class="fas fa-cog" aria-hidden="true"></i>&nbsp;<?php echo __('General:Manage'); ?>
                                        </button>
                                        <div class="absolute top-0 left-0 h-screen w-screen z-40" x-show="open">
                                            <div class="h-screen w-full z-40 inset-0 overflow-y-auto">
                                                <div @click="open = false" class="absolute w-full h-full inset-0 bg-gray-500 opacity-75"></div>
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"></span>
                                                    <div class="inline-block relative overflow-hidden transform transition-all sm:align-middle sm:max-w-lg" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                                        <div class="rounded-lg p-8 bg-white shadow">
                                                            <div class="absolute right-4 top-4">
                                                                <button @click="open = false" class="bg-transparent border border-transparent">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-6 w-6 text-gray-700" viewBox="0 0 1792 1792">
                                                                        <path d="M1490 1322q0 40-28 68l-136 136q-28 28-68 28t-68-28l-294-294-294 294q-28 28-68 28t-68-28l-136-136q-28-28-28-68t28-68l294-294-294-294q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 294 294-294q28-28 68-28t68 28l136 136q28 28 28 68t-28 68l-294 294 294 294q28 28 28 68z"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="p-4">
                                                                <form action="index.php" method="post">
                                                                    <div class="text-center mb-4 opacity-90">
                                                                        <a href="<?php echo get_user_profile_link($value); ?>" class="block relative">
                                                                            <img alt="<?php echo get_user_fullname($value); ?>" src="<?php echo get_user_profilephoto($value); ?>" class="mx-auto object-cover rounded-full h-16 w-16 "/>
                                                                        </a>
                                                                    </div>
                                                                    <div class="text-center">
                                                                        <div class="flex w-full">
                                                                            <span class="flex-grow">&nbsp;</span>
                                                                            <input type="text" name="firstname" class="text-2xl text-gray-800 dark:text-white w-1/3 inline text-right mr-2" value="<?php echo get_user_firstname($value); ?>">
                                                                            <input type="text" name="lastname" class="text-2xl text-gray-800 dark:text-white w-1/3 inline" value="<?php echo get_user_lastname($value); ?>">
                                                                            <span class="flex-grow">&nbsp;</span>
                                                                        </div>
                                                                        <p class="text-xl text-gray-500 dark:text-gray-200 font-light">
                                                                            <?php echo get_user_role($value); ?>
                                                                        </p>
                                                                        <?php if (SECURITY_USE_GSS && (check_gss_bans(get_user_last_login_ip($value)) != 'false')) { ?>
                                                                        <p class="text-red-500 dark:text-red-200 font-light pt-4">
                                                                            <?php echo __('Security:GSS_OnList'); ?>
                                                                        </p>
                                                                            <p class="text-sm text-red-500 dark:text-red-200 font-light">
                                                                                <?php echo __('Security:GSS_OnList_Reason'); ?> <?php echo get_gss_ban_reason(get_user_last_login_ip($value))?>
                                                                            </p>
                                                                            <p class="text-sm text-red-200 dark:text-red-500 font-light">
                                                                                <a class="text-red-300 hover:text-red-200 underline" href="https://saturncms.net/security/alert-list" target="_blank" rel="noopener"><?php echo __('Security:GSS_OnList_LearnMore'); ?> <i class="fas fa-external-link-alt fa-xs" aria-hidden="true"></i></a>
                                                                            </p>
                                                                        <?php } ?>
                                                                        <p class="text-md text-gray-500 dark:text-gray-400 max-w-xs py-4 font-light">
                                                                                <input type="text" name="userid" id="userid" value="<?php echo $value; ?>" class="hidden">
                                                                                <div class="relative inline-block w-full text-gray-700">
                                                                                    <select name="role" class="w-full h-10 pl-3 pr-6 text-base placeholder-gray-600 border rounded-lg appearance-none focus:shadow-outline">
                                                                                        <option value="4"<?php
                    if (get_user_roleID($value) == '4') {
                        echo' selected';
                    }
                    echo'>'.__('General:Administrator').'</option>
                                                                                        ';
                    if (CONFIG_PAGE_APPROVALS || get_user_roleID($value) == '3') {
                        echo'<option value="3"';
                        if (get_user_roleID($value) == '3') {
                            echo' selected';
                        }
                        echo'>'.__('General:Editor').'</option>';
                    }
                    echo'
                                                                                        <option value="2"';
                    if (get_user_roleID($value) == '2' || get_user_roleID($value) == '1') {
                        echo' selected';
                    }
                    echo'>'.__('General:Writer').'</option>
                                                                                        <option value="0"';
                    if (get_user_roleID($value) == '0') {
                        echo' selected';
                    }
                    echo'>'.__('General:Restricted').'</option>'; ?>
                                                                                    </select>
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                                                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                                                                                </div>
                                                                            </div>
                                                                            <input type="Submit" name="action" value="<?php echo __('General:Save'); ?>" class="cursor-pointer mt-2 px-1 py-2 font-normal hover:shadow-lg items-center justify-center w-24 tracking-wide text-white transition duration-200 rounded bg-<?php echo THEME_PANEL_COLOUR; ?>-500 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-400 focus:shadow-outline focus:outline-none">
                                                                        </p>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                <?php
                }
            }
            if ($empty) {
                echo __('Error:NoneFound');
            }
        }
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../common/panel/vendors.php'; ?>

        <title><?php echo __('Admin:UserManagement'); ?> - <?php echo CONFIG_SITE_NAME.' '.__('Admin:Panel'); ?></title>
        <?php require __DIR__.'/../../../common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../common/admin/navigation.php'; ?>

            <div class="px-8 py-4 block w-full">
                <div class="flex">
                    <h1 class="text-gray-900 text-3xl flex-grow"><?php echo __('Admin:UserManagement'); ?></h1>
                    <input type="text" id="searchBar" onkeyup="search()" placeholder="<?php echo __('General:Search'); ?>" class="border-b-2 border-blue-500 bg-gray-50 px-1 rounded-md mb-6">
                </div>
                <ul id="searchList" class="w-full mx-auto py-6">
                    <?php
                    if (isset($errorMsg)) {
                        echo '<div class="duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2 mt-2">
                                    <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                        <h6 class="mb-2 font-semibold leading-5">['.__('Error:Error').'] '.$errorMsg.'</h6>
                                    </div>
                                </div><br>';
                    }
                    unset($errorMsg);
                    if (isset($successMsg)) {
                        echo '<div class="duration-300 transform bg-green-100 border-l-4 border-green-500 hover:-translate-y-2 mt-2">
                                    <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                        <h6 class="mb-2 font-semibold leading-5">'.$successMsg.'</h6>
                                    </div>
                                </div><br>';
                    }
                    unset($successMsg);
                    ?>
                    <div class="w-full px-0 py-6 flex flex-wrap">
                        <div class="flex-grow mr-8 w-1/3 mb-8">
                            <h1 class="text-2xl font-bold leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900"><?php echo __('General:Administrators'); ?></h1>
                            <p class="text-xs font-light text-<?php echo THEME_PANEL_COLOUR; ?>-800"><?php echo __('Admin:UserManagement_Description_Administrator'); ?></p>
                            <?php
                            $empty = true;

                            $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` = '4' ORDER BY `first_name`;";

                            $rs = mysqli_query($conn, $query);

                            displayUser($rs);
                            ?>
                        </div>
                        <div class="flex-grow mr-8 w-1/3 mb-10">
                            <h1 class="text-2xl font-bold leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900"><?php echo __('General:Editors'); ?></h1>
                            <p class="text-xs font-light text-<?php echo THEME_PANEL_COLOUR; ?>-800"><?php echo __('Admin:UserManagement_Description_Editors'); ?></p>
                            <?php if (!CONFIG_PAGE_APPROVALS) {
                                echo '<p class="text-xs font-light italic text-red-800">'.__('Admin:UserManagement_Approvals_Disabled_Msg_1').' <a href="javascript:alert(\''.__('Admin:UserManagement_Approvals_Disabled_Msg_1').'\n\n'.__('Admin:UserManagement_Approvals_Disabled_Msg_2').'\n\n'.__('Admin:UserManagement_Approvals_Disabled_Msg_3').'\')" class="underline text-red-800">'.__('Admin:UserManagement_Approvals_Disabled_Msg_4').'</a></p>';
                            } ?>
                        <?php
                            $empty = true;

                            $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` = '3';";
                            $rs = mysqli_query($conn, $query);

                            displayUser($rs);
                            ?>
                        </div>
                        <div class="flex-grow mr-8 w-1/3 mb-10">
                            <h1 class="text-2xl font-bold leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900"><?php echo __('General:Writers'); ?></h1>
                            <p class="text-xs font-light text-<?php echo THEME_PANEL_COLOUR; ?>-800"><?php echo __('Admin:UserManagement_Description_Writers'); ?></p>
                            <?php
                            $empty = true;

                            $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` = '2';";
                            $rs = mysqli_query($conn, $query);

                            displayUser($rs);
                            ?>
                        </div>
                        <div class="flex-grow mr-8 w-1/3 mb-10">
                            <h1 class="text-2xl font-bold leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900"><?php echo __('General:Pending'); ?></h1>
                            <p class="text-xs font-light text-<?php echo THEME_PANEL_COLOUR; ?>-800"><?php echo __('Admin:UserManagement_Description_Pending'); ?></p>
                            <?php
                            $empty = true;

                            $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` = '1';";
                            $rs = mysqli_query($conn, $query);

                            displayUser($rs);
                            ?>
                        </div>
                        <div class="flex-grow mr-8 w-1/3 mb-10">
                            <h1 class="text-2xl font-bold leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-900"><?php echo __('General:Restricted'); ?></h1>
                            <p class="text-xs font-light text-<?php echo THEME_PANEL_COLOUR; ?>-800"><?php echo __('Admin:UserManagement_Description_Restricted'); ?></p>
                            <?php
                            $empty = true;

                            $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` = '0';";
                            $rs = mysqli_query($conn, $query);

                            displayUser($rs);
                            ?>
                        </div>
                        <div class="flex-grow mr-8 w-1/3 mb-10">
                            <h1 class="text-2xl font-bold leading-tight text-red-900"><?php echo __('Admin:UserManagement_Ban'); ?></h1>
                            <p class="text-xs font-light text-red-800"><?php echo __('Admin:UserManagement_Ban_Warning'); ?></p>
                            <form action="" method="POST" name="ban">
                                <select name="ban_user_id" class="w-full h-10 pl-3 pr-6 text-base placeholder-gray-600 border rounded-lg appearance-none focus:shadow-outline">
                                    <option value="NULL" disabled selected><?php echo __('Admin:UserManagement_Ban_Select'); ?></option>
                                <?php
                                $empty = true;

                                $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` <> '0' AND `role_id` <> '1';";
                                $rs = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
                                    foreach ($row as $value) {
                                        ?>
                                    <option value="<?php echo $value; ?>"><?php echo get_user_fullname($value); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                                <input type="text" name="reason" required class="w-full h-10 pl-3 pr-6 text-base placeholder-gray-600 border rounded-lg appearance-none focus:shadow-outline" placeholder="<?php echo __('Admin:UserManagement_Ban_Reason'); ?>" />
                                <input type="Submit" name="ban" value="<?php echo __('Admin:UserManagement_Ban'); ?>" class="cursor-pointer mt-2 px-1 py-2 font-normal hover:shadow-lg items-center justify-center w-24 tracking-wide text-white transition duration-200 rounded bg-red-500 hover:bg-red-400 focus:shadow-outline focus:outline-none">
                            </form>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <script>
            function search() {
                var input, filter, ul, li, a, i, txtValue;
                input = document.getElementById("searchBar");
                filter = input.value.toUpperCase();
                ul = document.getElementById("searchList");
                li = ul.getElementsByTagName("li");
                for (i = 0; i < li.length; i++) {
                    a = li[i].getElementsByTagName("name")[0];
                    txtValue = a.textContent || a.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        li[i].style.display = "";
                    } else {
                        li[i].style.display = "none";
                    }
                }
            }
        </script>
    </body>
</html>