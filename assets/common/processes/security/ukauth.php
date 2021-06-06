<?php
    function generate_uka_key() {
        $key = rand(1000000000, 9999999999);
        $hash = hash('sha3-512',$key);

        return $hash;
    }