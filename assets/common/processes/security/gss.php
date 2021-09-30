<?php

    function ban_user($id, $reason): bool
    {
        global $conn;

        $reason = checkInput('DEFAULT',$reason);
        $id = checkInput('DEFAULT',$id);

        $query = 'SELECT `last_login_ip` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;

        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        $ip = $row['last_login_ip'];

        $query = "UPDATE `".DATABASE_PREFIX."users` SET `first_name`='Restricted',`last_name`='User',`email`=NULL,`password`=NULL,`user_key`=NULL,`last_login_ip`=NULL,`auth_code`=NULL,`role_id`='0',`bio`=NULL,`organisation`=NULL,`website`=NULL,`profile_photo`='/assets/images/defaultprofile.png' WHERE id = ".$id;

        if (mysqli_query($conn, $query) && file_get_contents('https://link.saturncms.net/gss/?instruction=publish_ban&key='.CONFIG_ACTIVATION_KEY.'&domain='.$_SERVER['HTTP_HOST'].'&ip='.$ip.'&reason='.$reason)) {
            return true;
        } else {
            return false;
        }
    }