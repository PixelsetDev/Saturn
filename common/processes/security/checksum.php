<?php

    function checksum_generate($data): string
    {
        if (SECURITY_ACTIVE) {
            return hash(SECURITY_CHECKSUM_HASH, $data);
        }

        return 'Security Disabled';
    }

    function checksum_validate($data, $hash): bool
    {
        if (SECURITY_ACTIVE) {
            $dataHash = hash(SECURITY_CHECKSUM_HASH, $data);
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
