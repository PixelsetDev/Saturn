<?php
    function get_user_settings_notifications_saturn($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `notifications_saturn` FROM `'.DATABASE_PREFIX.'users_settings` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['notifications_saturn'];
    }

    function get_user_settings_notifications_email($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `notifications_email` FROM `'.DATABASE_PREFIX.'users_settings` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['notifications_email'];
    }

    function get_user_settings_privacy_abbreviate_surname($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `privacy_abbreviate_surname` FROM `'.DATABASE_PREFIX.'users_settings` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['privacy_abbreviate_surname'];
    }