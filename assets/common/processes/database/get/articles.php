<?php
    function get_article_title($id) {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = "SELECT `title` FROM `".DATABASE_PREFIX."articles` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['title'];
    }

    function get_article_content($id) {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = "SELECT `content` FROM `".DATABASE_PREFIX."articles` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['content'];
    }

    function get_article_references($id) {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = "SELECT `reference` FROM `".DATABASE_PREFIX."articles` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['reference'];
    }

    function get_article_status($id) {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = "SELECT `status` FROM `".DATABASE_PREFIX."articles` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['status'];
    }
