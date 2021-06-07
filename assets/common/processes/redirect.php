<?php
    function internal_redirect($url) {
        header('Location: ' . CONFIG_INSTALL_URL . $url);
        exit;
    }

    function redirect($url) {
        header('Location: ' . $url);
        exit;
    }