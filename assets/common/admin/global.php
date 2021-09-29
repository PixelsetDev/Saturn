<?php
if (get_user_roleID($_SESSION['id']) != '4') {
    header('Location: '.CONFIG_INSTALL_URL.'/panel/dashboard/?error=permission');
    echo 'You don\'t have the required permissions to access this page.';
    exit;
}