<?php
    function hash_ip($ip) {
        return hash('sha3-512',$ip);
    }

    function hash_general($data) {
        return hash('sha3-512',$data);
    }