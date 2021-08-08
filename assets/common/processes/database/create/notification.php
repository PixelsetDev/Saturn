<?php

    function create_notification($id, $title, $message): bool
    {
        $id = checkInput('DEFAULT', $id);
        $title = checkInput('DEFAULT', $title);
        $message = checkInput('DEFAULT', $message);

        $message = str_replace('\\', "<span style='display:none;'>\\</span>", $message);

        // Get user notification preference
        $type = get_user_notification_preference($id);

        if ($type == '1') {
            global $conn;
            $query = 'INSERT INTO `'.DATABASE_PREFIX."notifications` (`id`, `user_id`, `dismissed`, `title`, `content`) VALUES (NULL, '".$id."', '0', '".$title."', '".$message."')";
            if (mysqli_query($conn, $query)) {
                $return = true;
            } else {
                $return = false;
            }
        } elseif ($type == '2') {
            $email = get_user_email($id);
            send_email($email, 'Saturn Notification: '.$title, $message);
            $return = true;
        } elseif ($type == '3') {
            global $conn;
            $query = 'INSERT INTO `'.DATABASE_PREFIX."notifications` (`id`, `user_id`, `dismissed`, `title`, `content`) VALUES (NULL, '".$id."', '0', '".$title."', '".$message."')";
            $email = get_user_email($id);
            send_email($email, 'Saturn Notification: '.$title, $message);
            if (mysqli_query($conn, $query)) {
                $return = true;
            } else {
                $return = false;
            }
        } else {
            $return = false;
        }

        return $return;
    }
