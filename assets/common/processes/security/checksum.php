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

    function config_validate(): bool {
        if(SECURITY_ACTIVE) {
            $new = file_get_contents(__DIR__.'/../../../../../config.php');
            return checksum_validate($new, CONFIG_CHECKSUM);
        }
    }