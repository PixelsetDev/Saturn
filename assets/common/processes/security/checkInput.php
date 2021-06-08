<?php
    function checkInput($mode, $data) {
        global $conn;

        if(SECURITY_ACTIVE === true) {
            $data = mysqli_real_escape_string($conn, $data);
            $data = checkData( $data, 'PHP', '<?', '&lt;?');
            $data = checkData( $data, 'External JavaScript', '<script src=', '&lt;script src=');
            $data = checkData( $data, 'External JavaScript', '<script src =', '&lt;script src =');
            $data = checkData( $data, 'External CSS', '<link', '&lt;link');
            if ($mode == 'DEFAULT') {
                $data = htmlspecialchars($data);
                $data = checkData( $data, 'JavaScript', '<script', '&lt;script');
                $data = checkData( $data, 'CSS', '<css', '&ltstyle');
                $data = checkData( $data, 'CSS', 'css =', 'blocked =');
                $data = checkData( $data, 'CSS', 'css=', 'blocked=');
            } else if ($mode == 'HTML') {
                $data = checkData( $data, 'JavaScript', '<script', '&lt;script');
                $data = checkData( $data, 'CSS', '<css', '&ltstyle');
                $data = checkData( $data, 'CSS', 'css =', 'blocked =');
                $data = checkData( $data, 'CSS', 'css=', 'blocked=');
            } else if ($mode == 'TAGCSS') {
                $data = checkData( $data, 'JavaScript', '<script', '&lt;script');
                $data = checkData( $data, 'CSS', '<css', '&ltstyle');
            } else if ($mode == 'CSS') {
                $data = checkData( $data, 'JavaScript', '<script', '&lt;script');
            } else if ($mode == 'JS') {
                $data = checkData( $data, 'CSS', '<css', '&ltstyle');
                $data = checkData( $data, 'CSS', 'css =', 'blocked =');
                $data = checkData( $data, 'CSS', 'css=', 'blocked=');
            }
        }
        return $data;
    }