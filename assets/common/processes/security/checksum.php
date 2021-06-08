<?php
    function checksum_generate($data): String {
        if(SECURITY_ACTIVE) {
            return hash('sha512', $data);
        }
        return 'Security Disabled';
    }

    function checksum_validate($data, $hash): bool {
        if(SECURITY_ACTIVE) {
            $dataHash = hash('sha512', $data);
            if ($hash == $dataHash) {
                $return = true;
            } else {
                $return = false;
            }
            return $return;
        } else {
            return false;
        }
    }

    function checksum_validate_config(): bool {
        if(SECURITY_ACTIVE) {
            $new = file_get_contents(__DIR__.'/../../../../config.php');
            return checksum_validate($new, CONFIG_CHECKSUM);
        } else {
            return false;
        }
    }

    function checksum_generate_config(): bool {
        $currentFile = file_get_contents(__DIR__.'/../../../../config.php');
        $newChecksum = checksum_generate($currentFile);
        $message = "<?php
    // You shouldn't change these values. If you do, it can cause errors to appear within Saturn.
    const CONFIG_CHECKSUM = '".$newChecksum."';";
        $file = __DIR__.'/../../../storage/core_checksum.php';
        return file_put_contents($file, $message, LOCK_EX);
    }