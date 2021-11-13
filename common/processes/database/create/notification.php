<?php

    function create_notification($id, $title, $message)
    {
        $id = checkInput('DEFAULT', $id);
        $title = checkInput('HTML', $title);
        $message = checkInput('HTML', $message);

        $message = str_replace('\\', "", $message);

        // Get user notification preference
        $type = get_user_notification_preference($id);

        if ($type == '1') {
            global $conn;
            $query = 'INSERT INTO `'.DATABASE_PREFIX."notifications` (`id`, `user_id`, `dismissed`, `title`, `content`, `timestamp`) VALUES (NULL, '".$id."', '0', '".$title."', '".$message."', current_timestamp());";
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
            $query = 'INSERT INTO `'.DATABASE_PREFIX."notifications` (`id`, `user_id`, `dismissed`, `title`, `content`, `timestamp`) VALUES (NULL, '".$id."', '0', '".$title."', '".$message."', current_timestamp());";
            $email = get_user_email($id);
            $dbSuccess = mysqli_query($conn, $query);
            $emailSuccess = send_email($email, 'Saturn Notification: '.$title, $message);
            if ($dbSuccess && $emailSuccess) {
                $return = true;
            } else {
                if (!$dbSuccess) {
                    log_file('SATURN][Database', 'ERROR: Unable to run SQL Query: '.$query);
                }
                if (!$emailSuccess) {
                    log_file('SATURN][Email', 'ERROR: Unable to send email from notification.php, please check your email settings in config.php');
                }
                $return = false;
            }
        } else {
            $return = false;
        }

        return $return;
    }
