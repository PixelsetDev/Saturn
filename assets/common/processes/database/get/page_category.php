<?php
    function get_page_category_homepage($id) {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `homepage_id` FROM `'.DATABASE_PREFIX."pages_categories` WHERE `id` = '".$id."'";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['homepage_id'];
    }