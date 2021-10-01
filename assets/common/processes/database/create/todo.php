<?php

    function create_todo_list($listOwnerID, $listTitle, $listDescription, $listRoleID, $listVisibility): bool
    {
        $listOwnerID = checkInput('DEFAULT', $listOwnerID);
        $listTitle = checkInput('DEFAULT', $listTitle);
        $listDescription = checkInput('DEFAULT', $listDescription);
        $listRoleID = checkInput('DEFAULT', $listRoleID);
        $listVisibility = checkInput('DEFAULT', $listVisibility);

        global $conn;

        $query = 'INSERT INTO `'.DATABASE_PREFIX."todo_lists` (`id`, `name`, `description`, `owner_id`, `role_id`, `visibility`, `status`) VALUES (NULL, '".$listTitle."', '".$listDescription."', '".$listOwnerID."', '".$listRoleID."', '".$listVisibility."', '1')";

        return mysqli_query($conn, $query);
    }

    function create_todo_item($listID, $title, $description): bool
    {
        $listID = checkInput('DEFAULT', $listID);
        $title = checkInput('DEFAULT', $title);
        $description = checkInput('DEFAULT', $description);

        global $conn;

        $query = 'INSERT INTO `'.DATABASE_PREFIX."todo_items` (`id`, `list_id`, `title`, `description`, `status`) VALUES (NULL, '".$listID."', '".$title."', '".$description."', '0')";

        var_dump($query);

        return mysqli_query($conn, $query);
    }
