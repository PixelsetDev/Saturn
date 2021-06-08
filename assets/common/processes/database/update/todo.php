<?php
    function update_todo_list_status($id, $data): bool {
        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."todo_lists` SET `status` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }
