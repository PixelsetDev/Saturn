<?php
    function create_notification($id, $title, $message): bool
    {
        // Get user notification preference
        $type=get_user_notification_preference($id);

        if($type == '1') {
            global $conn;
            $query = "INSERT INTO `".DATABASE_PREFIX."notifications` (`id`, `user_id`, `dismissed`, `title`, `content`) VALUES (NULL, '".$id."', '0', '".$title."', '".$message."')";
            if(mysqli_query($conn, $query)) {
                $return = true;
            } else {
                $return = false;
            }
        } else if ($type == '2') {
            $email = get_user_email($id);
            send_email($email,'Saturn Notification: '.$title, $message);
            $return = true;
        } else if($type == '3') {
            global $conn;
            $query = "INSERT INTO `".DATABASE_PREFIX."notifications` (`id`, `user_id`, `dismissed`, `title`, `content`) VALUES (NULL, '".$id."', '0', '".$title."', '".$message."')";
            $email = get_user_email($id);
            send_email($email,'Saturn Notification: '.$title, $message);
            if(mysqli_query($conn, $query)) {
                $return = true;
            } else {
                $return = false;
            }
        } else {
            $return = false;
        }
        if($return === true) {
            return true;
        } else {
            return false;
        }
    }