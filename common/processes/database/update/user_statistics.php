<?php
    function update_user_statistics_increment_pageviews($userid)
    {
        $userid = checkInput('DEFAULT', $userid);

        global $conn;

        $pageviews = get_user_statistics_views($userid)+1;

        $query = "UPDATE `".DATABASE_PREFIX."users_statistics` SET `views` = '".$pageviews."' WHERE `id` = ".$userid;

        return mysqli_query($conn, $query);
    }