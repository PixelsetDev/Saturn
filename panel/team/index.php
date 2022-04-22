<?php
session_start();
include_once __DIR__.'/../../common/global_private.php';

function listUsers($role)
{
    global $conn;
    $found = false;

    $query = 'SELECT `id`, `first_name` FROM `'.DATABASE_PREFIX."users` WHERE `role_id` = '".$role."' ORDER BY `first_name`";
    $rs = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
        echo '<br>';
        foreach ($row as $key => $value) {
            if (is_numeric($value)) {
                echo'<li>
                                <a href="'.get_user_profile_link($value).'" id="'.get_user_fullname($value).'" class="relative inline-block">
                                    <img class="inline-block object-cover w-12 h-12 rounded-full" src="'.get_user_profilephoto($value).'" alt="'.get_user_fullname($value).'">
                                    <span class="absolute bottom-0 right-0 inline-block w-3 h-3 bg-'.get_activity_colour($value).'-600 border-2 border-white dark:border-neutral-700 rounded-full"></span>
                                </a>
                                <b>'.get_user_fullname($value).'</b>
                            </li>';
                $found = true;
            }
        }
    }
    if (!$found) {
        echo '<p class="mt-6">None found.</p>';
    }
}?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../common/panel/vendors.php';
            include_once __DIR__.'/../../common/panel/theme.php';
        ?>

        <title>Team - Saturn Panel</title>
    </head>
    <body class="mb-8 dark:bg-neutral-700 dark:text-white">
        <?php include_once __DIR__.'/../../common/panel/navigation.php'; ?>

        <header class="bg-white shadow dark:bg-neutral-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex">
                <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white flex-grow">Team</h1>
                <input type="text" id="searchBar" onkeyup="search()" placeholder="<?php echo __('General:Search'); ?>" class="border-b-2 border-blue-500 bg-gray-50 dark:bg-neutral-900 dark:text-white dark:border-blue-900 px-1 rounded-md">
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            <ul id="searchList" class="w-full px-4 py-6 sm:px-0 flex">
                <div class="flex-auto mr-8 w-1/3">
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">Administration</h1>
                    <?php
                        listUsers('4');
                    ?>
                </div>
                <div class="flex-auto mr-8 w-1/3">
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">Editors</h1>
                    <?php
                        listUsers('3');
                    ?>
                </div>
                <div class="flex-auto mr-8 w-1/3">
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">Writers</h1>
                    <?php
                        listUsers('2');
                    ?>
                </div>
            </ul>
            <a href="chat" class="text-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-300">
                <div class="mt-10 py-4 bg-<?php echo THEME_PANEL_COLOUR; ?>-200 rounded-lg hover:shadow-xl w-full text-center" style="background-image: url('<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/background.jpg');">
                    <span class="text-2xl">Team Chat</span>
                </div>
            </a>
        </div>
        <script>
            function search() {
                var input, filter, ul, li, a, i, txtValue;
                input = document.getElementById("searchBar");
                filter = input.value.toUpperCase();
                ul = document.getElementById("searchList");
                li = ul.getElementsByTagName("li");
                for (i = 0; i < li.length; i++) {
                    a = li[i].getElementsByTagName("b")[0];
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