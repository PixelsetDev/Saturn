<?php
    function update_todo_list_status($id, $data): bool {
        $id = checkInput('DEFAULT', $id);
        $data = checkInput('DEFAULT', $data);

        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."todo_lists` SET `status` = '".$data."' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }
