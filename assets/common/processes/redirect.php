<?php

    function internal_redirect($url)
    {
        $url = checkInput('DEFAULT', $url);
        header('Location: ' . CONFIG_INSTALL_URL . $url);
        echo '<meta http-equiv="refresh" content="0; url=' . CONFIG_INSTALL_URL . $url . '">';
        exit;
    }

    function redirect($url)
    {
        $url = checkInput('DEFAULT', $url);
        header('Location: ' . $url);
        echo '<meta http-equiv="refresh" content="0; url=' . $url . '">';
        exit;
    }
