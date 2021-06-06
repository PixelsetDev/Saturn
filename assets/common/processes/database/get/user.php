<?php
    function get_user_id($username) {
        global $conn;

        $query = "SELECT `id` FROM `".DATABASE_PREFIX."users` WHERE `username` = '".$username."'";
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['id'];
    }

    function get_user_username($id) {
        global $conn;

        $query = "SELECT `username` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['username'];
    }

    function get_user_firstname($id) {
        global $conn;

        $query = "SELECT `first_name` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['first_name'];
    }

    function get_user_lastname($id) {
        global $conn;

        $query = "SELECT `last_name` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['last_name'];
    }

    function get_user_fullname($id) {
        global $conn;

        $query = "SELECT `first_name`, `last_name` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);
        $fullname = $row['first_name'].' '.$row['last_name'];

        return $fullname;
    }

    function get_user_email($id) {
        global $conn;

        $query = "SELECT `email` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['email'];
    }

    function get_user_role($id) {
        global $conn;

        $query = "SELECT `role_id` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;
        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);
        $q = $row['role_id'];

        if ($q == '0') { $role = 'Restricted'; }
        else if ($q == '1') { $role = 'Pending'; }
        else if ($q == '2') { $role = 'Writer'; }
        else if ($q == '3') { $role = 'Editor'; }
        else if ($q == '4') { $role = 'Administrator'; }
        else if ($q == '-1') { $role = 'Deleted'; }

        return $role;
    }

    function get_user_roleID($id): int {
        global $conn;

        $query = "SELECT `role_id` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['role_id'];
    }

    function get_user_bio($id) {
        global $conn;

        $query = "SELECT `bio` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['bio'];
    }

    function get_user_website($id) {
        global $conn;

        $query = "SELECT `website` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['website'];
    }

    function get_user_profilephoto($id) {
        global $conn;

        $query = "SELECT `profile_photo` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['profile_photo'];
    }

    function get_user_views($id) {
        global $conn;

        $query = "SELECT `views` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['views'];
    }

    function get_user_edits($id) {
        global $conn;

        $query = "SELECT `edits` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['edits'];
    }

    function get_user_approvals($id) {
        global $conn;

        $query = "SELECT `approvals` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['approvals'];
    }

    function get_user_page_count($id) {
        global $conn;

        $query = "SELECT `id` FROM `".DATABASE_PREFIX."pages` WHERE `user_id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $rows = mysqli_num_rows($rs);

        return $rows;
    }

    function get_user_article_count($id) {
        global $conn;

        $query = "SELECT `id` FROM `".DATABASE_PREFIX."articles` WHERE `author_id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $rows = mysqli_num_rows($rs);

        return $rows;
    }

    function get_user_key($id) {
        global $conn;

        $query = "SELECT `user_key` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['user_key'];
    }

    function get_user_auth_code($id): string {
        global $conn;

        $query = "SELECT `auth_code` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['auth_code'];
    }

    function get_user_last_login_ip($id): string {
        global $conn;

        $query = "SELECT `last_login_ip` FROM `".DATABASE_PREFIX."users` WHERE `id` = ".$id;

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);

        return $row['last_login_ip'];
    }

    function get_user_profile_link($id): string {
        $link = CONFIG_INSTALL_URL.'/panel/team/profile/?u='.get_user_username($id);
        return $link;
    }

    function get_user_email_exists($email): bool {
        global $conn;

        $query = "SELECT `id` FROM `".DATABASE_PREFIX."users` WHERE `email` = '".$email."'";

        $rs = mysqli_query($conn,$query);
        $rows = mysqli_num_rows($rs);

        if($rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    function get_user_notification_preference($id): int {
        return '1';
    }