<?php
    function errorHandlerWarning($errno, $errstr) {
        if(CONFIG_PHP_ERRORS == true) {
            echo '<div class="duration-300 transform bg-yellow-100 border-l-4 border-yellow-500">
                        <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                            <h6 class="mb-2 font-semibold leading-5">['.date("H:i").'][WARNING]['. $errno .'] <span class="font-medium">' . $errstr . '</span></h6>
                        </div>
                    </div>';
        }
    }
    function errorHandlerError($errno, $errstr) {
        if(CONFIG_PHP_ERRORS == true) {
            echo '<div class="duration-300 transform bg-red-100 border-l-4 border-red-500">
                                <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                                    <h6 class="mb-2 font-semibold leading-5">['.date("H:i").'][ERROR]['. $errno .'] <span class="font-medium">' . $errstr . '</span></h6>
                                </div>
                            </div>';
        }
    }
    function errorHandlerNotice($errno, $errstr) {
        if(CONFIG_PHP_NOTICES == true) {
            echo '<div class="duration-300 transform bg-blue-100 border-l-4 border-blue-500">
                                <div class="h-auto p-5 border border-l-0 rounded-r shadow-sm">
                                    <h6 class="mb-2 font-semibold leading-5">['.date("H:i").'][NOTICE] <span class="font-medium">' . $errstr . '</span></h6>
                                </div>
                            </div>';
        }
    }
    function errorHandlerRedirect($errcode) {
        global $errorScreen;
        if (isset($errorScreen) == false) {
            echo '<meta http-equiv="refresh" content="0;url=' . CONFIG_INSTALL_URL . '/error.php?error=' . $errcode . '" />';
        }
    }