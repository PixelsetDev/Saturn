<?php
    function update_user_edits($id, $data) {
        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."users` SET `edits` = '".$data."' WHERE `id` = ".$id;

        if(mysqli_query($conn, $query)){return true;}else{return false;}
    }

    function update_user_approvals($id, $data) {
        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."users` SET `approvals` = '".$data."' WHERE `id` = ".$id;

        if(mysqli_query($conn, $query)){return true;}else{return false;}
    }

    function update_user_key($id, $data) {
        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."users` SET `user_key` = '".$data."' WHERE `id` = ".$id;

        if(mysqli_query($conn, $query)){return true;}else{return false;}
    }

    function update_user_auth_code($id, $data) {
        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."users` SET `auth_code` = '".$data."' WHERE `id` = ".$id;

        if(mysqli_query($conn, $query)){return true;}else{return false;}
    }

    function update_user_last_login_ip($id, $data) {
        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."users` SET `last_login_ip` = '".$data."' WHERE `id` = ".$id;

        if(mysqli_query($conn, $query)){return true;}else{return false;}
    }

    function update_user_role_id($id, $data) {
        global $conn;

        $query = "UPDATE `".DATABASE_PREFIX."users` SET `role_id` = '".$data."' WHERE `id` = ".$id;

        if(mysqli_query($conn, $query)){return true;}else{return false;}
    }