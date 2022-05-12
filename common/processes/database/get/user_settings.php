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

    function get_user_settings_security_2fa($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `security_2fa` FROM `'.DATABASE_PREFIX.'users_settings` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['security_2fa'];
    }

    function get_user_accepted_terms($id): bool
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `accepted_terms` FROM `'.DATABASE_PREFIX.'users_settings` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['accepted_terms'];
    }

    function get_user_language($id): bool
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `language` FROM `'.DATABASE_PREFIX.'users_settings` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['language'];
    }

    function get_user_notification_preference($id): int
    {
        $id = checkInput('DEFAULT', $id);

        $saturn = get_user_settings_notifications_saturn($id);
        $email = get_user_settings_notifications_email($id);

        if ($saturn && !$email && CONFIG_ALLOW_SATURN_NOTIFICATIONS) {
            $return = '1';
        } elseif (!$saturn && $email && CONFIG_ALLOW_EMAIL_NOTIFICATIONS) {
            $return = '2';
        } elseif ($saturn && $email) {
            if (CONFIG_ALLOW_SATURN_NOTIFICATIONS && CONFIG_ALLOW_EMAIL_NOTIFICATIONS) {
                $return = '3';
            } elseif (!CONFIG_ALLOW_SATURN_NOTIFICATIONS && CONFIG_ALLOW_EMAIL_NOTIFICATIONS) {
                $return = '2';
            } elseif (CONFIG_ALLOW_SATURN_NOTIFICATIONS && !CONFIG_ALLOW_EMAIL_NOTIFICATIONS) {
                $return = '1';
            }
        }

        return $return;
    }
