<?php

    function get_user_id($username)
    {
        $username = checkInput('DEFAULT', $username);

        global $conn;

        $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `username` = '".$username."'";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['id'];
    }

    function get_user_username($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `username` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['username'];
    }

    function get_user_firstname($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `first_name` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['first_name'];
    }

    function get_user_lastname($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `last_name` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        if (get_user_settings_privacy_abbreviate_surname($id)) {
            $lastname = $row['last_name'];

            return substr($lastname, 0);
        } else {
            return $row['last_name'];
        }
    }

    function get_user_fullname($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `first_name`, `last_name` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        if (get_user_settings_privacy_abbreviate_surname($id)) {
            $lastname = $row['last_name'];
            $lastname = substr($lastname, 0, 1);

            return $row['first_name'].' '.$lastname;
        } else {
            return $row['first_name'].' '.$row['last_name'];
        }
    }

    function get_user_email($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `email` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['email'];
    }

    function get_user_role($id): int
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `role_id` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);
        $q = $row['role_id'];

        if ($q == '0') {
            $role = 'Restricted';
        } elseif ($q == '1') {
            $role = 'Pending';
        } elseif ($q == '2') {
            $role = 'Writer';
        } elseif ($q == '3') {
            $role = 'Editor';
        } elseif ($q == '4') {
            $role = 'Administrator';
        } elseif ($q == '-1') {
            $role = 'Deleted';
        } else {
            $role = 'Unknown';
        }

        return $role;
    }

    function get_user_roleID($id): int
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `role_id` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['role_id'];
    }

    function get_user_bio($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `bio` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['bio'];
    }

    function get_user_website($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `website` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['website'];
    }

    function get_user_profilephoto($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `profile_photo` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['profile_photo'];
    }

    function get_user_page_count($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `id` FROM `'.DATABASE_PREFIX.'pages` WHERE `user_id` = '.$id;

        $rs = mysqli_query($conn, $query);

        return mysqli_num_rows($rs);
    }

    function get_user_article_count($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `id` FROM `'.DATABASE_PREFIX.'articles` WHERE `author_id` = '.$id;

        $rs = mysqli_query($conn, $query);

        return mysqli_num_rows($rs);
    }

    function get_user_key($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `user_key` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['user_key'];
    }

    function get_user_auth_code($id): string
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `auth_code` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['auth_code'];
    }

    function get_user_last_login_ip($id): string
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `last_login_ip` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['last_login_ip'];
    }

    function get_user_profile_link($id): string
    {
        $id = checkInput('DEFAULT', $id);

        return CONFIG_INSTALL_URL.'/panel/team/profile/?u='.get_user_username($id);
    }

    function get_user_email_exists($email): bool
    {
        $email = checkInput('DEFAULT', $email);

        global $conn;

        $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."users` WHERE `email` = '".$email."'";

        $rs = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($rs);

        if ($rows == 0) {
            $return = false;
        } else {
            $return = true;
        }

        return $return;
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

    function get_user_last_seen($id): string
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `last_seen` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['last_seen'];
    }
