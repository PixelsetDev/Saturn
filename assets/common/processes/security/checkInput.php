<?php
    function checkInput($mode, $data) {
        global $conn;

        if(SECURITY_ACTIVE == true) {
            $data = mysqli_real_escape_string($conn, $data);
            $data = checkPHPTag($data);
            $data = checkExternalJS($data);
            $data = checkExternalCSS($data);
            if ($mode == 'DEFAULT') {
                $data = htmlspecialchars($data);
                $data = checkJS($data);
                $data = checkCSS($data);
                $data = checkTagCSS($data);
            } else if ($mode == 'HTML') {
                $data = checkJS($data);
                $data = checkCSS($data);
                $data = checkTagCSS($data);
            } else if ($mode = 'TAGCSS') {
                $data = checkJS($data);
                $data = checkCSS($data);
            } else if ($mode == 'CSS') {
                $data = checkJS($data);
            } else if ($mode == 'JS') {
                $data = checkCSS($data);
                $data = checkTagCSS($data);
            }
        }
        return $data;
    }