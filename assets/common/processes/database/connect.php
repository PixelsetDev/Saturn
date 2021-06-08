<?php
    $conn = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_PORT);
    if (mysqli_connect_errno($conn)) {
        if(CONFIG_DEBUG === true) {
            errorHandlerError('x', 'Failed to connect to MySQL Database. Please check your config.php file and try again. Error: '.mysqli_connect_error());
            log_console('Saturn][Database', 'Unable to connect to the Database.');
        }
        errorHandlerRedirect('db_conn');
    } else {
        if(CONFIG_DEBUG === true) {
            log_console('Saturn][Database', 'Connected to the Database.');
        }
    }
    $query = "SET time_zone = '".CONFIG_SITE_TIMEZONE."';";
    $rs = mysqli_query($conn,$query);
    unset($query,$rs);