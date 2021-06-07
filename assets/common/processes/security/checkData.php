<?php
    function checkData( $data, $alert, $illegalCode, $replacement): string {
        if (strpos($data, $illegalCode) !== false) { log_security_blocked($alert);
            if(SECURITY_MODE == 'clean') {
                $data = str_ireplace($data, $illegalCode, $replacement);
            } else if (SECURITY_MODE == 'stop') {header('Location: '.CONFIG_INSTALL_URL.'/panel/system/error/?err=security');exit;}
        }

        return $data;
    }