<?php
    function create_page($url,$categoryID,$template,$title,$description): bool{
        global $conn;

        $query = "INSERT INTO `".DATABASE_PREFIX."pages` (`id`, `user_id`, `category_id`, `url`, `template`, `title`, `description`, `content`, `reference`) VALUES (NULL, '".$_SESSION['id']."', '".$categoryID."', '".$url."', '".$template."', '".$title."', '".$description."', NULL, NULL)";

        if(mysqli_query($conn, $query)){}else{return false;}

        $query = "INSERT INTO `".DATABASE_PREFIX."pages_pending` (`id`, `user_id`, `category_id`, `title`, `content`, `reference`) VALUES (NULL, '0', '".$categoryID."', NULL, NULL, NULL)";

        if(mysqli_query($conn, $query)){return true;}else{return false;}
    }