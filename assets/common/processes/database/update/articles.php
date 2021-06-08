<?php
    function update_article_content($id, $data): bool {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."articles` SET `content` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_article_references($id, $data): bool {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."articles` SET `reference` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }

    function update_article_status($id, $data): bool {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."articles` SET `status` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }