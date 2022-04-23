<?php

    function get_user_statistics_views_pages($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `page_views` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['page_views'];
    }

    function get_user_statistics_views_articles($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `article_views` FROM `'.DATABASE_PREFIX.'users_statistics` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['article_views'];
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
