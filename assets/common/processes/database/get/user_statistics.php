<?php

    function get_user_statistics_views($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `views` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['views'];
    }

    function get_user_statistics_edits($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `edits` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['edits'];
    }

    function get_user_statistics_approvals($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `approvals` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['approvals'];
    }
