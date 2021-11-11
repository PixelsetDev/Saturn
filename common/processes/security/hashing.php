<?php

    function hash_ip($ip)
    {
        return hash(SECURITY_DEFAULT_HASH, $ip);
    }

    function hash_general($data)
    {
        return hash(SECURITY_DEFAULT_HASH, $data);
    }
