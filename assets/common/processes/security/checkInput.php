<?php
    function checkInput($mode, $data) {
        global $conn;

        if(SECURITY_ACTIVE == true) {
            $data = mysqli_real_escape_string($conn, $data);
            $data = checkPHPTag($data);
            $data = checkExternalJS($data);
            $data = checkExternalCSS($data);
            if ($mode == 'DEFAULT') {
                $data = htmlspecialchars($data);
                $data = checkJS($data);
                $data = checkCSS($data);
                $data = checkTagCSS($data);
            } else if ($mode == 'HTML') {
                $data = checkJS($data);
                $data = checkCSS($data);
                $data = checkTagCSS($data);
            } else if ($mode = 'TAGCSS') {
                $data = checkJS($data);
                $data = checkCSS($data);
            } else if ($mode == 'CSS') {
                $data = checkJS($data);
            } else if ($mode == 'JS') {
                $data = checkCSS($data);
                $data = checkTagCSS($data);
            }
        }
        return $data;
    }

    function checkPHPTag($data) {
        if (strpos($data, '<?') !== false) {
            log_security_blocked('PHP');
            if (SECURITY_MODE == 'clean') {
                $data = str_ireplace($data, "<?", "&lt;?");
            } else if (SECURITY_MODE == 'stop') {
                header('Location: ' . CONFIG_INSTALL_URL . '/panel/system/error/?err=security');
                exit;
            }
        }

        return $data;
    }

    function checkJS($data) {
        if (strpos($data, '<script') !== false) { log_security_blocked('JavaScript');
            if(SECURITY_MODE == 'clean') {
                $data = str_ireplace($data, "<script", "&lt;script");
            } else if (SECURITY_MODE == 'stop') {header('Location: '.CONFIG_INSTALL_URL.'/panel/system/error/?err=security');exit;}
        }

        return $data;
    }

    function checkExternalJS($data) {
        if (strpos($data, '<script src=') !== false) {
            log_security_blocked('External JavaScript');
            if (SECURITY_MODE == 'clean') {
                $data = str_ireplace($data, "<script src=", "&lt;script src=");
            } else if (SECURITY_MODE == 'stop') {
                header('Location: ' . CONFIG_INSTALL_URL . '/panel/system/error/?err=security');
                exit;
            }
        }
        if (strpos($data, '<script src =') !== false) {
            log_security_blocked('External JavaScript');
            if (SECURITY_MODE == 'clean') {
                $data = str_ireplace($data, "<script src =", "&lt;script src =");
            } else if (SECURITY_MODE == 'stop') {
                header('Location: ' . CONFIG_INSTALL_URL . '/panel/system/error/?err=security');
                exit;
            }
        }

        return $data;
    }

    function checkCSS($data) {
        if (strpos($data, '<style') !== false) { log_security_blocked('CSS');
            if(SECURITY_MODE == 'clean') {
                $data = str_ireplace($data, "<style", "&ltstyle");
            } else if (SECURITY_MODE == 'stop') {header('Location: '.CONFIG_INSTALL_URL.'/panel/system/error/?err=security');exit;}
        }

        return $data;
    }

    function checkExternalCSS($data) {
        if (strpos($data, '<link') !== false) {
            log_security_blocked('External CSS');
            if (SECURITY_MODE == 'clean') {
                $data = str_ireplace($data, "<link", "&lt;link");
            } else if (SECURITY_MODE == 'stop') {
                header('Location: ' . CONFIG_INSTALL_URL . '/panel/system/error/?err=security');
                exit;
            }
        }

        return $data;
    }

    function checkTagCSS($data) {
        if (strpos($data, 'style =') !== false) {
            log_security_blocked('CSS');
            if (SECURITY_MODE == 'clean') {
                $data = str_ireplace($data, "style =", "blocked =");
            } else if (SECURITY_MODE == 'stop') {
                header('Location: ' . CONFIG_INSTALL_URL . '/panel/system/error/?err=security');
                exit;
            }
        }
        if (strpos($data, 'style=') !== false) {
            log_security_blocked('CSS');
            if (SECURITY_MODE == 'clean') {
                $data = str_ireplace($data, "style=", "blocked=");
            } else if (SECURITY_MODE == 'stop') {
                header('Location: ' . CONFIG_INSTALL_URL . '/panel/system/error/?err=security');
                exit;
            }
        }

        return $data;
    }