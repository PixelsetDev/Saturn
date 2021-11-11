<?php

    function update_page_description($id, $data): bool
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."pages` SET `description` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_page_category($id, $data): bool
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."pages` SET `category` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_page_template($id, $data): bool
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."pages` SET `template` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_page_url($id, $data): bool
    {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = 'UPDATE `'.DATABASE_PREFIX."pages` SET `url` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }
