<?php

    function create_article($title): bool
    {
        $title = checkInput('DEFAULT', $title);

        global $conn;

        $query = 'INSERT INTO `'.DATABASE_PREFIX."articles` (`id`, `author_id`, `title`, `content`, `reference`, `status`) VALUES (NULL, '".$_SESSION['id']."', '".$title."', NULL, NULL, 'UNPUBLISHED')";

        if (mysqli_query($conn, $query)) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }
