<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../assets/common/global_private.php';
            include_once __DIR__.'/../../assets/common/panel/vendors.php';
            include_once __DIR__.'/../../assets/common/panel/theme.php';
        ?>

        <title>Saturn Panel</title>
    </head>
    <body class="mb-8">
        <?php include_once __DIR__.'/../../assets/common/panel/navigation.php'; ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Team</h1>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="w-full px-4 py-6 sm:px-0 flex">
                <div class="flex-auto mr-8 w-1/3">
                    <h1 class="text-2xl font-bold leading-tight text-gray-900">Administration</h1>
                    <?php

                        $query = 'SELECT `id`, `first_name` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` = '4' ORDER BY `first_name`";
                        $rs = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
                            echo '<br>';
                            foreach ($row as $key => $value) {
                                if (is_numeric($value)) {
                                    echo'<div>
                            <a href="'.get_user_profile_link($value).'" class="relative inline-block">
                                <img class="inline-block object-cover w-12 h-12 rounded-full" src="'.get_user_profilephoto($value).'" alt="'.get_user_fullname($value).'">
                                <span class="absolute bottom-0 right-0 inline-block w-3 h-3 bg-'.get_activity($value).'-600 border-2 border-white rounded-full"></span>
                            </a>
                            <b>'.get_user_fullname($value).'</b>
                        </div>';
                                }
                            }
                        }
                    ?>
                </div>
                <div class="flex-auto mr-8 w-1/3">
                    <h1 class="text-2xl font-bold leading-tight text-gray-900">Editors</h1>
                    <?php

                    $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` = '3'";
                    $rs = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
                        echo '<br>';
                        foreach ($row as $key => $value) {
                            if (is_numeric($value)) {
                                echo'<div>
                            <a href="'.get_user_profile_link($value).'" class="relative inline-block">
                                <img class="inline-block object-cover w-12 h-12 rounded-full" src="'.get_user_profilephoto($value).'" alt="'.get_user_fullname($value).'">
                                <span class="absolute bottom-0 right-0 inline-block w-3 h-3 bg-'.get_activity($value).'-600 border-2 border-white rounded-full"></span>
                            </a>
                            <b>'.get_user_fullname($value).'</b>
                        </div>';
                            }
                        }
                    }
                    ?>
                </div>
                <div class="flex-auto mr-8 w-1/3">
                    <h1 class="text-2xl font-bold leading-tight text-gray-900">Writers</h1>
                    <?php

                    $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` = '2'";
                    $rs = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
                        echo '<br>';
                        foreach ($row as $key => $value) {
                            if (is_numeric($value)) {
                                echo'<div>
                            <a href="'.get_user_profile_link($value).'" class="relative inline-block">
                                <img class="inline-block object-cover w-12 h-12 rounded-full" src="'.get_user_profilephoto($value).'" alt="'.get_user_fullname($value).'">
                                <span class="absolute bottom-0 right-0 inline-block w-3 h-3 bg-'.get_activity($value).'-600 border-2 border-white rounded-full"></span>
                            </a>
                            <b>'.get_user_fullname($value).'</b>
                        </div>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <a href="chat" class="text-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-300">
                <div class="mt-10 py-4 bg-<?php echo THEME_PANEL_COLOUR; ?>-200 rounded-lg hover:shadow-xl w-full text-center" style="background-image: url('<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/background.jpg');">
                    <span class="text-2xl">Team Chat</span>
                </div>
            </a>
        </div>
    </body>
</html>