<?php
    function create_todo_list($listOwnerID,$listTitle,$listDescription,$listRoleID,$listVisibility): bool{
        global $conn;

        $query = "INSERT INTO `".DATABASE_PREFIX."todo_lists` (`id`, `name`, `description`, `owner_id`, `role_id`, `visibility`, `status`) VALUES (NULL, '".$listTitle."', '".$listDescription."', '".$listOwnerID."', '".$listRoleID."', '".$listVisibility."', '1')";

        if(mysqli_query($conn, $query)){
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }