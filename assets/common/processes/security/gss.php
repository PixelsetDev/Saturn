<?php
    function ban_publish($ip, $reason): bool
    {
        $reason = checkInput('DEFAULT',$reason);
        $ip = checkInput('DEFAULT',$ip);
        if (file_get_contents('https://link.saturncms.net/gss/?instruction=publish_ban&key='.CONFIG_ACTIVATION_KEY.'&domain='.$_SERVER['HTTP_HOST'].'&ip='.$ip.'&reason='.$reason)) {
            return true;
        } else {
            return false;
        }
    }