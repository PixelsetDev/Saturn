<?php
    function delete_page($pageID): bool {
        $pageID = checkInput('DEFAULT', $pageID);

        global $conn;

        $query = "DELETE FROM `".DATABASE_PREFIX."pages` WHERE `id` = ".$pageID;

        if (mysqli_query($conn, $query)) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }