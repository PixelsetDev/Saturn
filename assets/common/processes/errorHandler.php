<?php
    function errorHandlerWarning($errno, $errstr) {
        if(CONFIG_DEBUG) {
            errorHandler($errno, $errstr, 'WARNING', 'yellow');
        }
    }

    function errorHandlerError($errno, $errstr) {
        if(CONFIG_DEBUG) {
            errorHandler($errno, $errstr, 'ERROR', 'red');
        }
    }

    function errorHandlerNotice($errno, $errstr) {
        if(CONFIG_DEBUG) {
            errorHandler($errno, $errstr, 'NOTICE', 'blue');
        }
    }

    function errorHandler($errno, $errstr, $type, $colour) {
        if(CONFIG_DEBUG) {
            echo '<div class="duration-300 transform bg-'.$colour.'-100 border-l-4 border-'.$colour.'-500">
                                <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                                    <h6 class="mb-2 font-semibold leading-5">['.date("H:i").']['.$type.']['.$errno.'] <span class="font-medium">'.$errstr.'</span></h6>
                                </div>
                            </div>';
        }
    }

    function errorHandlerRedirect($errcode) {
        global $errorScreen;
        if (!isset($errorScreen)) {
            echo '<meta http-equiv="refresh" content="0;url=' . CONFIG_INSTALL_URL . '/error.php?error=' . $errcode . '" />';
        }
    }