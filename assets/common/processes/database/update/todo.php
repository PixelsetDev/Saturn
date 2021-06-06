<?php
    function update_todo_list_status($id, $data): bool {
        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."todo_lists` SET `status` = '".$data."' WHERE `id` = ".$id;

        if(mysqli_query($conn, $query)){return true;}else{return false;}
    }
