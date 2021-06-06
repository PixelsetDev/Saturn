<?php
    function checkOutput($mode, $data) {
        $data = checkInput($mode, $data);
        return $data;
    }