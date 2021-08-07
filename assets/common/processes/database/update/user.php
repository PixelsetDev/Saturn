<?php

    function update_user_firstname($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `first_name` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_lastname($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `last_name` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_bio($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `bio` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_website($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `website` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_edits($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `edits` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_approvals($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `approvals` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_key($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `user_key` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_auth_code($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `auth_code` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_last_login_ip($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `last_login_ip` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_role_id($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `role_id` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_user_last_seen($id, $data)
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."users` SET `last_seen` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }
