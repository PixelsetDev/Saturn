<?php

function get_assigned_writers()
{
    global $conn;

    echo '</div>
                                </div>
                            <div class="container mx-auto">
                                    Assigned Writers:
                                    <div class="flex -space-x-1 overflow-hidden">';
    $query = 'SELECT `id` FROM `'.DATABASE_PREFIX.'users` WHERE 1;';
    $result = mysqli_query($conn, $query);
    $users = mysqli_fetch_all($result);
    foreach ($users as $uid) {
        if (get_user_roleID($uid[0]) != '1') {
            echo'<a href="'.get_user_profile_link($uid[0]).'" class="relative inline-block">
                                                <img class="bg-white dark:bg-gray-700 inline-block h-6 w-6 rounded-full ring-2 ring-white dark:ring-gray-700" src="'.get_user_profilephoto($uid[0]).'" title="'.get_user_fullname($uid[0]).'" alt="'.get_user_fullname($uid[0]).'">
                                                <span class="absolute bottom-0 right-0 inline-block w-2 h-2 bg-'.get_activity_colour($uid[0]).'-600 border-2 border-white dark:border-bg-gray-700 rounded-full"></span>
                                            </a>';
        }
    }
    echo '</div>
                                </div>
                            </div>';
}

function get_assigned_editors()
{
    global $conn;
    echo '<div class="flex">
                                <div class="container mx-auto">
    Assigned Editors:
                                    <div class="flex -space-x-1 overflow-hidden">';
    $query = 'SELECT `id` FROM `'.DATABASE_PREFIX.'users` WHERE 1;';
    $result = mysqli_query($conn, $query);
    $users = mysqli_fetch_all($result);
    foreach ($users as $uid) {
        if (get_user_roleID($uid[0]) == '3' || get_user_roleID($uid[0]) == '4') {
            echo'<a href="'.get_user_profile_link($uid[0]).'" class="relative inline-block">
                                                <img class="bg-white dark:bg-gray-700 inline-block h-6 w-6 rounded-full ring-2 ring-white dark:ring-gray-700" src="'.get_user_profilephoto($uid[0]).'" title="'.get_user_fullname($uid[0]).'" alt="'.get_user_fullname($uid[0]).'">
                                                <span class="absolute bottom-0 right-0 inline-block w-2 h-2 bg-'.get_activity_colour($uid[0]).'-600 border-2 border-white dark:border-bg-gray-700 rounded-full"></span>
                                            </a>';
        }
    }
}

function pageQuery_1($i)
{
    global $conn;

    $query = 'select title, id from '.DATABASE_PREFIX."pages where category_id = '$i'";
    $rs = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($rs);

    return $row['id'];
}
function pageQuery_2($i, $o)
{
    global $conn;

    $query = 'select title, id from '.DATABASE_PREFIX."pages where category_id = '$i' AND id = '$o'";
    $rs = mysqli_query($conn, $query);

    return mysqli_fetch_assoc($rs);
}
