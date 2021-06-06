<?php
    function hash_ip($ip) {
        $hash = hash('sha3-512',$ip);

        return $hash;
    }
    function hash_general($data) {
        $hash = hash('sha3-512',$data);

        return $hash;
    }