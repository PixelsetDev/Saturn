<?php

function get_assigned_writers()
{
    echo '</div>
                                </div>
                            <div class="container mx-auto">
                                    Assigned Writers:
                                    <div class="flex -space-x-1 overflow-hidden">';
    $uid = 1;
    $users = get_user_firstname($uid);
    while ($users != null) {
        if (get_user_roleID($uid) != '1') {
            echo '<a href="'.get_user_profile_link($uid).'" class="relative inline-block">
                                                <img class="bg-white inline-block h-6 w-6 rounded-full ring-2 ring-white" src="'.get_user_profilephoto($uid).'" title="'.get_user_fullname($uid).'" alt="'.get_user_fullname($uid).'">
                                                <span class="absolute bottom-0 right-0 inline-block w-2 h-2 bg-'.get_activity($uid).'-600 border-2 border-white rounded-full"></span>
                                            </a>';
            $uid++;
            $users = get_user_firstname($uid);
        }
    }
    echo '</div>
                                </div>
                            </div>';
}

function get_assigned_editors()
{
    echo '<div class="flex">
                                <div class="container mx-auto">
    Assigned Editors:
                                    <div class="flex -space-x-1 overflow-hidden">';
    $uid = 1;
    $users = get_user_firstname($uid);
    while ($users != null) {
        if (get_user_roleID($uid) == '3' || get_user_roleID($uid) == '4') {
            echo'<a href="'.get_user_profile_link($uid).'" class="relative inline-block">
                                                <img class="bg-white inline-block h-6 w-6 rounded-full ring-2 ring-white" src="'.get_user_profilephoto($uid).'" title="'.get_user_fullname($uid).'" alt="'.get_user_fullname($uid).'">
                                                <span class="absolute bottom-0 right-0 inline-block w-2 h-2 bg-'.get_activity($uid).'-600 border-2 border-white rounded-full"></span>
                                            </a>';
        }
        $uid++;
        $users = get_user_firstname($uid);
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
