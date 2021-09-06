<?php

    function get_notification_count($user_id)
    {
        $user_id = checkInput('DEFAULT', $user_id);

        global $conn;

        $query = 'SELECT title FROM `'.DATABASE_PREFIX."notifications` WHERE `user_id` = '".$user_id."' AND `dismissed` = '0'";
        $rs = mysqli_query($conn, $query);

        return mysqli_num_rows($rs);
    }

    function get_notification_title($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT title FROM `'.DATABASE_PREFIX."notifications` WHERE `id` = '".$id."';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['title'];
    }

    function get_notification_content($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT content FROM `'.DATABASE_PREFIX."notifications` WHERE `id` = '".$id."';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['content'];
    }

    function get_notification_timestamp($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT timestamp FROM `'.DATABASE_PREFIX."notifications` WHERE `id` = '".$id."';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['timestamp'];
    }

    function get_latest_notification_id($user_id)
    {
        $user_id = checkInput('DEFAULT', $user_id);

        global $conn;

        $query = 'SELECT id FROM `'.DATABASE_PREFIX."notifications` WHERE `user_id` = '".$user_id."' AND `dismissed` = '0' ORDER BY id ASC";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['id'];
    }

    function get_latest_notification_title($user_id)
    {
        $user_id = checkInput('DEFAULT', $user_id);

        global $conn;

        $query = 'SELECT title FROM `'.DATABASE_PREFIX."notifications` WHERE `user_id` = '".$user_id."' AND `dismissed` = '0' ORDER BY id ASC";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['title'];
    }

    function get_latest_notification_content($user_id)
    {
        $user_id = checkInput('DEFAULT', $user_id);

        global $conn;

        $query = 'SELECT content FROM `'.DATABASE_PREFIX."notifications` WHERE `user_id` = '".$user_id."' AND `dismissed` = '0' ORDER BY id ASC";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['content'];
    }
