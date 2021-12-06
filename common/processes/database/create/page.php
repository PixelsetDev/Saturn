<?php

function create_page($url, $categoryID, $template, $title, $description): bool
{
    $url = checkInput('DEFAULT', $url);
    $categoryID = checkInput('DEFAULT', $categoryID);
    $template = checkInput('DEFAULT', $template);
    $title = checkInput('DEFAULT', $title);
    $description = checkInput('DEFAULT', $description);

    global $conn;

    $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."pages` WHERE `url` = '".$url."'";
    if (mysqli_num_rows(mysqli_query($conn, $query)) != 0) {
        log_error('WARNING', get_user_username($_SESSION['id'].' attempted to create a page but it already existed.'));

        return false;
    }

    $query = 'INSERT INTO `'.DATABASE_PREFIX."pages` (`id`, `user_id`, `category_id`, `url`, `template`, `title`, `description`, `content`, `reference`, `image_url`, `image_credit`, `image_license`) VALUES (NULL, '".$_SESSION['id']."', '".$categoryID."', '".$url."', '".$template."', '".$title."', '".$description."', NULL, NULL, '', '', '')";
    $query2 = 'INSERT INTO `'.DATABASE_PREFIX."pages_pending` (`id`, `user_id`, `category_id`, `title`, `content`, `reference`) VALUES (NULL, '0', '".$categoryID."', NULL, NULL, NULL)";

    if (mysqli_query($conn, $query) && mysqli_query($conn, $query2)) {
        $return = true;
    } else {
        $return = false;
    }

    return $return;
}

function create_category($title, $homepage): bool
{
    $title = checkInput('DEFAULT', $title);
    $homepage = checkInput('DEFAULT', $homepage);

    global $conn;

    $query = 'INSERT INTO `'.DATABASE_PREFIX."pages_categories` (`id`, `name`, `homepage_id`) VALUES (NULL, '".$title."', '".$homepage."')";

    if (mysqli_query($conn, $query)) {
        $return = true;
    } else {
        $return = false;
    }

    return $return;
}
