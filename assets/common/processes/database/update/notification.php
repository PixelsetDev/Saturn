<?php
    function update_notification_dismiss($id): bool {
        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."notifications` SET `dismissed` = '1' WHERE `id` = ".$id;

        return mysqli_query($conn, $query);
    }