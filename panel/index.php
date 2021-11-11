<?php
    ob_start();
    session_start();
    include_once __DIR__ . '/../assets/common/global_public.php';
    if (isset($_SESSION['id'])) {
        header('Location: '.CONFIG_INSTALL_URL.'/panel/dashboard');
    } else {
        header('Location: '.CONFIG_INSTALL_URL.'/panel/account/signin');
    }
    ob_end_flush();