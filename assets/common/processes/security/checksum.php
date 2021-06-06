<?php
    function checksum_generate($data): String {
        if(SECURITY_ACTIVE == true) {
            $hash = hash('sha512', $data);
            return $hash;
        }
        return 'Security Disabled';
    }

    function checksum_validate($data, $hash): bool {
        if(SECURITY_ACTIVE == true) {
            $dataHash = hash('sha512', $data);
            if ($hash == $dataHash) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }