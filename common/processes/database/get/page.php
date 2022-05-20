<?php

    function get_page_title($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `title` FROM `'.DATABASE_PREFIX.'pages` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['title'];
    }

    function get_page_content($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `content` FROM `'.DATABASE_PREFIX.'pages` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['content'];
    }

    function get_page_references($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `reference` FROM `'.DATABASE_PREFIX.'pages` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['reference'];
    }

    function get_page_template($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `template` FROM `'.DATABASE_PREFIX.'pages` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['template'];
    }

    function get_page_pending_title($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `title` FROM `'.DATABASE_PREFIX.'pages_pending` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['title'];
    }

    function get_page_pending_content($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `content` FROM `'.DATABASE_PREFIX.'pages_pending` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['content'];
    }

    function get_page_pending_references($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `reference` FROM `'.DATABASE_PREFIX.'pages_pending` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['reference'];
    }

    function get_page_pending_user_id($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `user_id` FROM `'.DATABASE_PREFIX.'pages_pending` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['user_id'];
    }

    function get_page_last_edit_user_id($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `id`, `user_id` FROM `'.DATABASE_PREFIX."pages_history` WHERE `page_id` = '".$id."' ORDER BY `id` DESC";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['user_id'];
    }

    function get_page_last_edit_timestamp($id)
    {
        $id = checkInput('DEFAULT', $id);

        if ($id != null) {
            global $conn;

            $query = 'SELECT `id`, `timestamp` FROM `' . DATABASE_PREFIX . "pages_history` WHERE `page_id` = '" . $id . "' ORDER BY `id` DESC";
            $rs = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($rs);

            return $row['timestamp'];
        } else {
            return 'Unknown';
        }
    }

    function get_page_url($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `url` FROM `'.DATABASE_PREFIX."pages` WHERE `id` = '".$id."';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['url'];
    }

    function get_page_description($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `description` FROM `'.DATABASE_PREFIX."pages` WHERE `id` = '".$id."';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['description'];
    }

    function get_page_status($id): string
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `content` FROM `'.DATABASE_PREFIX.'pages` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        $query2 = 'SELECT `content` FROM `'.DATABASE_PREFIX.'pages_pending` WHERE `id` = '.$id;
        $rs2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_assoc($rs2);

        if ($row2['content'] != null && $row2['content'] != '') {
            return 'yellow';
        } elseif ($row['content'] != null && $row['content'] != '') {
            return 'green';
        } else {
            return 'red';
        }
    }

    function get_page_image($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `image_url` FROM `'.DATABASE_PREFIX."pages` WHERE `id` = '".$id."';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['image_url'];
    }

    function get_page_image_credit($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `image_credit` FROM `'.DATABASE_PREFIX."pages` WHERE `id` = '".$id."';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['image_credit'];
    }

    function get_page_image_license($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `image_license` FROM `'.DATABASE_PREFIX."pages` WHERE `id` = '".$id."';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['image_license'];
    }
