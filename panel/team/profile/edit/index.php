<?php session_start();

include_once __DIR__.'/../../../../assets/common/global_private.php';
$user = $_SESSION['id'];

if(isset($_POST['save'])) {
    $bio = str_ireplace('\\', '', $_POST['bio']); // Fixes issue of many backwards slashes appearing.
    $bio = checkInput('DEFAULT', $bio);
    $link = checkInput('DEFAULT', $_POST['link']);
    $fullname = checkInput('DEFAULT', $_POST['fullname']);
    $namearray = explode(' ', $fullname, 2);

    update_user_bio($user,$bio);
    update_user_website($user,$link);
    update_user_firstname($user,$namearray[0]);
    update_user_lastname($user,$namearray[1]);

    if(isset($_POST['notificationsSaturn'])) {
        update_user_settings_notifications_saturn($user,'1');
    } else {
        update_user_settings_notifications_saturn($user,'0');
    }
    if(isset($_POST['notificationsEmail'])) {
        update_user_settings_notifications_email($user,'1');
    } else {
        update_user_settings_notifications_email($user,'0');
    }
}

?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../../../assets/common/panel/vendors.php';
            include_once __DIR__.'/../../../../assets/common/panel/theme.php';
        ?>

        <title>Edit <?php echo get_user_fullname($user); ?>'s Profile - Saturn Panel</title>

    </head>
    <body class="mb-8">
        <?php include_once __DIR__.'/../../../../assets/common/panel/navigation.php'; ?>
        <form class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" method="post" action="index.php">
            <div class="w-full h-48" style="background: url('<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/background.jpg');">
                <div class="max-w-7xl flex mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                    <div class="h-32 w-32 py-2 px-2 md:h-48 md:w-48 md:py-4 md:px-4 relative inline-block">
                        <img class="h-28 w-28 md:h-40 md:w-40 bg-white rounded-full" src="<?php echo get_user_profilephoto($user); ?>" alt="<?php echo get_user_fullname($user); ?>">
                        <span class="absolute inline-block bg-<?php echo get_activity($user); ?>-600 rounded-full border-black bottom-4 right-4 w-4 h-4 border-2 md:border-white md:bottom-5 md:right-5 md:w-8 md:h-8 md:border-4"></span>
                    </div>
                    <div class="flex flex-wrap items-center w-3/4">
                        <div class="w-3/4 flex flex-wrap">
                            <div>
                                <input type="text" id="fullname" name="fullname" value="<?php echo get_user_fullname($user); ?>" class="flex-grow self-center text-white font-extrabold tracking-tight text-5xl md:text-6xl w-3/4 bg-gray-100 bg-opacity-50" />
                                <span class="self-center text-white font-extrabold tracking-tight text-5xl md:text-6xl w-3/4 bg-transparent">
                                    <i class="fas fa-pencil-alt text-white" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <?php if ($user == $_SESSION['id']) {
            echo'<input type="submit" id="save" name="save" value="Save Profile" class="cursor-pointer h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-blue-500 hover:bg-blue-600 text-white bg-transparent font-semibold">';
        } ?>
                    </div>
                </div>
            </div>
            <div class="flex pt-16 pb-10">
                <div class="ml-10">
                    <ul class="flex justify-content-around items-center">
                        <li class="mr-4">
                            <span class="block text-base flex"><span class="font-bold mr-2"><?php echo get_user_statistics_views($user); ?> </span> Views</span>
                        </li>
                        <li class="mr-4">
                            <span class="block text-base flex"><span class="font-bold mr-2"><?php echo get_user_statistics_edits($user); ?> </span> Edits</span>
                        </li>
                        <?php if (get_user_roleID($user) > 2 && get_user_roleID($_SESSION['id']) > 2) {
            echo '<li class="mr-4">
                                    <span class="block text-base flex"><span class="font-bold mr-2">'.get_user_statistics_approvals($user).' </span> Approvals</span>
                                </li>';
        } ?>
                    </ul>
                    <br>
                    <div class="">
                        <div class="flex"><input type="text" id="bio" name="bio" value="<?php echo str_ireplace('\\', '', get_user_bio($user)); ?>" class="text-base bg-gray-100 bg-opacity-50" maxlength="100"/><i class="fas fa-pencil-alt fa-lg text-black" aria-hidden="true"></i></div>
                        <div class="flex"><input type="text" id="link" name="link" value="<?php echo get_user_website($user); ?>" class="block text-base text-blue-500 mt-2 bg-gray-100 bg-opacity-50" /><i class="fas fa-pencil-alt fa-lg text-black" aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
            <div class="border-b border-gray-300 my-6"></div>
            <div class="flex">
                <h1 class="text-2xl">Your Preferences</h1>
                <?php if ($user == $_SESSION['id']) {
                    echo'<input type="submit" id="save" name="save" value="Save" class="cursor-pointer h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-blue-500 hover:bg-blue-600 text-white bg-transparent font-semibold">';
                } ?>
            </div>
            <div class="flex flex-wrap space-x-16">
                <div name="notifications">
                    <h1 class="text-xl mt-4">Notifications</h1>
                    <?php
                    if(get_user_settings_notifications_email($user)=='0' && get_user_settings_notifications_saturn($user)=='0') {
                        alert('INFO','You must have at least one notification preference enabled. We have enabled Saturn notifications to ensure you stay up to date with relevant information regarding your account.');
                        update_user_settings_notifications_saturn($user,'1');
                    }
                    ?>
                    <div class="flex space-x-2 mt-2">
                        <input type="checkbox" name="notificationsSaturn" id="notificationsSaturn" value="true" class="self-center"<?php if (get_user_settings_notifications_saturn($user)) { echo ' checked'; } ?>>
                        <span class="self-center">Saturn Notifications</span>
                    </div>
                    <div class="flex space-x-2">
                        <input type="checkbox" name="notificationsEmail" id="notificationsEmail" value="true" class="self-center"<?php if (get_user_settings_notifications_email($user)) { echo ' checked'; } ?>>
                        <span class="self-center">Email Notifications</span>
                    </div>
                </div>
                <div name="notifications">
                    <h1 class="text-xl mt-4">Security</h1>
                    <?php
                    if(get_user_settings_notifications_email($user)=='0' && get_user_settings_notifications_saturn($user)=='0') {
                        alert('INFO','You must have at least one notification preference enabled. We have enabled Saturn notifications to ensure you stay up to date with relevant information regarding your account.');
                        update_user_settings_notifications_saturn($user,'1');
                    }
                    ?>
                    <div class="flex space-x-2 mt-2">
                        <input type="checkbox" name="security2FA" id="security2FA" value="true" class="self-center"<?php if (false) { echo ' checked'; } ?> disabled>
                        <span class="self-center">Two Factor Authentication</span>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>