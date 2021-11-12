<?php

    const DATE_FORMAT = 'Y/m/d H:i:s';

    function log_all($prefix, $message)
    {
        $prefix = strtoupper($prefix);
        $prefix = checkOutput('DEFAULT', $prefix);
        $message = checkOutput('DEFAULT', $message);
        if (LOGGING_ACTIVE === true) {
            log_console($prefix, $message);
            log_file($prefix, $message);
        }
    }

    function log_console($prefix, $message)
    {
        $prefix = strtoupper($prefix);
        $prefix = checkOutput('DEFAULT', $prefix);
        $message = checkOutput('DEFAULT', $message);
        if (LOGGING_ACTIVE && CONFIG_DEBUG) {
            echo '<script>console.log("'.date(DATE_FORMAT).' ['.$prefix.'] '.$message.'");</script>';
        }
    }

    function log_file($prefix, $message)
    {
        $prefix = strtoupper($prefix);
        $prefix = checkOutput('DEFAULT', $prefix);
        $message = checkOutput('DEFAULT', $message);
        if (LOGGING_ACTIVE === true) {
            $message = date(DATE_FORMAT).' ['.$prefix.'] '.$message."\r\n";
            $file = __DIR__.'/../../../storage/logs/security.txt';
            file_put_contents($file, $message, FILE_APPEND | LOCK_EX);
        }
    }

    function log_security_blocked($value)
    {
        if (LOGGING_ACTIVE && SECURITY_ACTIVE && CONFIG_DEBUG) {
            echo '<script>console.log("'.date(DATE_FORMAT).' [SATURN][GSS] ';
            if (SECURITY_MODE == 'clean') {
                echo'Cleaned';
            } else {
                echo'Stopped';
            }
            echo' I/O: Contained Blacklisted Item: '.$value.'.");</script>';
        }
    }

    function log_clear($type): bool
    {
        if ($type == 'SECURITY') {
            $message = get_user_fullname($_SESSION['id']).' cleared the Security Log.';
            $message = date(DATE_FORMAT).' [SATURN][SECURITY] '.$message."\r\n";
            $file = __DIR__.'/../../../storage/logs/security.txt';
            file_put_contents($file, $message, LOCK_EX);

            return true;
        } elseif ($type == 'ERROR') {
            $message = get_user_fullname($_SESSION['id']).' cleared the Error Log.';
            $message = date(DATE_FORMAT).' [NOTICE] '.$message."\r\n";
            $file = __DIR__.'/../../../storage/logs/errors.txt';
            file_put_contents($file, $message, LOCK_EX);

            return true;
        } else {
            return false;
        }
    }
