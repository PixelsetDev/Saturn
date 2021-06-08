<?php
    function log_all($prefix, $message) {
        $prefix = strtoupper($prefix);
        $prefix = checkOutput('DEFAULT', $prefix);
        $message = checkOutput('DEFAULT', $message);
        if (LOGGING_ACTIVE === true) {
            log_console($prefix, $message);
            log_file($prefix, $message);
        }
    }

    function log_console($prefix, $message) {
        $prefix = strtoupper($prefix);
        $prefix = checkOutput('DEFAULT', $prefix);
        $message = checkOutput('DEFAULT', $message);
        if (LOGGING_ACTIVE && CONFIG_DEBUG) {
            echo '<script>console.log("' . date("H:i:s").' ['.$prefix . '] '.$message.'");</script>';
        }
    }

    function log_file($prefix, $message) {
        $prefix = strtoupper($prefix);
        $prefix = checkOutput('DEFAULT', $prefix);
        $message = checkOutput('DEFAULT', $message);
        if (LOGGING_ACTIVE === true) {
            $message = date("H:i:s").' ['.$prefix.'] '.$message."\r\n";
            $file = __DIR__.'/../../../storage/security_log.txt';
            file_put_contents($file, $message, FILE_APPEND | LOCK_EX);
        }
    }

    function log_security_blocked($value) {
        if (LOGGING_ACTIVE && SECURITY_ACTIVE && CONFIG_DEBUG) {
            echo '<script>console.log("'.date("H:i:s").' [SATURN][GSS] ';if(SECURITY_MODE=='clean'){echo'Cleaned';}else{echo'Stopped';}echo' I/O: Contained Blacklisted Item: '.$value.'.");</script>';
        }
    }

    function log_clear(): bool {
        $message = get_user_fullname($_SESSION['id']).' cleared the Security Log.';
        $message = date("H:i:s").' [SATURN][SECURITY] '.$message."\r\n";
        $file = __DIR__.'/../../../storage/security_log.txt';
        file_put_contents($file, $message, LOCK_EX);
        return true;
    }