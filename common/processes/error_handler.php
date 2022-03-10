<?php

    function errorHandlerWarning($errno, $errstr)
    {
        if (CONFIG_DEBUG) {
            errorHandler($errno, $errstr, 'WARNING', 'yellow');
        }
        if (LOGGING_ACTIVE) {
            log_error('WARNING', $errstr);
        }
    }

    function errorHandlerError($errno, $errstr)
    {
        if (CONFIG_DEBUG) {
            errorHandler($errno, $errstr, 'ERROR', 'red');
        }
        if (LOGGING_ACTIVE) {
            log_error('ERROR', $errstr);
        }
    }

    function errorHandlerNotice($errno, $errstr)
    {
        if (CONFIG_DEBUG) {
            errorHandler($errno, $errstr, 'NOTICE', 'blue');
        }
        if (LOGGING_ACTIVE) {
            log_error('NOTICE', $errstr);
        }
    }

    function errorHandler($errno, $errstr, $type, $colour)
    {
        if (CONFIG_DEBUG) {
            echo '<div class="transform hover:-translate-y-2 bg-'.$colour.'-50 dark:'.$colour.' dark:text-white border-l-4 border-'.$colour.'-500 dark:border-'.$colour.'-900 p-2 shadow-lg hover:shadow-xl flex transition duration-200">
                                <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                                    <h6 class="mb-2 font-semibold leading-5">['.date('H:i').']['.$type.']['.$errno.'] <span class="font-medium">'.$errstr.'</span></h6>
                                </div>
                            </div>';
        }
        if (LOGGING_ACTIVE) {
            log_error($type, $errstr);
        }
    }

    function errorHandlerRedirect($errcode)
    {
        global $errorScreen;
        if (!isset($errorScreen)) {
            echo '<meta http-equiv="refresh" content="0;url=//'.$_SERVER['HTTP_HOST'].CONFIG_INSTALL_URL.'/error.php?error='.$errcode.'" />';
        }
    }

    function log_error($prefix, $message)
    {
        $prefix = checkOutput('DEFAULT', $prefix);
        $message = checkOutput('DEFAULT', $message);

        if (LOGGING_ACTIVE === true) {
            $message = date(DATE_FORMAT).' ['.$prefix.'] '.$message."\r\n";
            $file = __DIR__.'/../../storage/logs/errors.txt';
            file_put_contents($file, $message, FILE_APPEND | LOCK_EX);
        }
    }
