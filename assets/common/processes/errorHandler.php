<?php

    function errorHandlerWarning($errno, $errstr)
    {
        if (CONFIG_DEBUG) {
            errorHandler($errno, $errstr, 'WARNING', 'yellow');
        }
        log_error('WARNING',$errstr);
    }

    function errorHandlerError($errno, $errstr)
    {
        if (CONFIG_DEBUG) {
            errorHandler($errno, $errstr, 'ERROR', 'red');
        }
        log_error('ERROR',$errstr);
    }

    function errorHandlerNotice($errno, $errstr)
    {
        if (CONFIG_DEBUG) {
            errorHandler($errno, $errstr, 'NOTICE', 'blue');
        }
        log_error('NOTICE',$errstr);
    }

    function errorHandler($errno, $errstr, $type, $colour)
    {
        if (CONFIG_DEBUG) {
            echo '<div class="duration-300 transform bg-'.$colour.'-100 border-l-4 border-'.$colour.'-500">
                                <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                                    <h6 class="mb-2 font-semibold leading-5">['.date('H:i').']['.$type.']['.$errno.'] <span class="font-medium">'.$errstr.'</span></h6>
                                </div>
                            </div>';
        }
        log_error($type,$errstr);
    }

    function errorHandlerRedirect($errcode)
    {
        global $errorScreen;
        if (!isset($errorScreen)) {
            echo '<meta http-equiv="refresh" content="0;url=//'.$_SERVER['HTTP_HOST'].CONFIG_INSTALL_URL.'/error.php?error='.$errcode.'" />';
        }
    }

    function log_error($type, $message)
    {
        $type = checkOutput('DEFAULT', $type);
        $message = checkOutput('DEFAULT', $message);

        if (LOGGING_ACTIVE === true) {
            $message = date(DATE_FORMAT).' ['.$type.'] '.$message."\r\n";
            $file = __DIR__.'/../../../storage/error.log';
            file_put_contents($file, $message, FILE_APPEND | LOCK_EX);
        }
    }
