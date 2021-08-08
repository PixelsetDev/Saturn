<?php

    function update_user_settings_notifications_saturn($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users_settings` SET `notifications_saturn` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_settings_notifications_email($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users_settings` SET `notifications_email` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_settings_privacy_abbreviate_surname($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users_settings` SET `privacy_abbreviate_surname` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_settings_security_2fa($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users_settings` SET `security_2fa` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }