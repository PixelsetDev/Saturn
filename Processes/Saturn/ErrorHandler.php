<?php

namespace Saturn;

class ErrorHandler
{
    public function Register(): void
    {
        set_error_handler('Saturn\\ErrorHandler::Fatal', E_USER_ERROR);
        set_error_handler('Saturn\\ErrorHandler::Error', E_ERROR);
        set_error_handler('Saturn\\ErrorHandler::Warning', E_WARNING);
        set_error_handler('Saturn\\ErrorHandler::Notice', E_NOTICE);
    }

    public function Fatal($errno, $errstr, $errfile, $errline): void
    {
        echo out('<p style="color: red;">Fatal error: '.$errstr.'</p>');
        exit;
    }

    public function Error($errno, $errstr, $errfile, $errline): void
    {
        echo out('<p style="color: orange;">Error: '.$errstr.'</p>');
    }

    public function Warning($errno, $errstr, $errfile, $errline): void
    {
        echo out('<p style="color: yellow;">Warning: '.$errstr.'</p>');
    }

    public function Notice($errno, $errstr, $errfile, $errline): void
    {
        echo out('<p style="color: blue;">Notice: '.$errstr.'</p>');
    }

    public function SaturnError($HTTPCode, $SaturnCode, $ErrorName, $ErrorDescription, $DocsURL)
    {
        $ErrorCode = $HTTPCode;
        $ErrorMessage = '['.$SaturnCode.'] '.$DocsURL;
        require_once __DIR__.'/DefaultViews/Error.php';
        exit;
    }
}
