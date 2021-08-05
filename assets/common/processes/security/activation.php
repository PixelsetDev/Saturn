<?php

    function activation_validate(): bool
    {
        $activation_key = file_get_contents("https://link.saturncms.net/?key_status=" . CONFIG_ACTIVATION_KEY);
        $activation_key_url = file_get_contents("https://link.saturncms.net/?key_registered_url=" . CONFIG_ACTIVATION_KEY);
        if ($activation_key == '1' && $activation_key_url == $_SERVER['HTTP_HOST']) {
            return true;
        } else {
            return false;
        }
    }