<?php

namespace Saturn;

class ErrorHandler {
    public function Register(): void
    {
        set_error_handler("Saturn\\ErrorHandler::Fatal", E_USER_ERROR);
        set_error_handler("Saturn\\ErrorHandler::Error", E_ERROR);
        set_error_handler("Saturn\\ErrorHandler::Warning", E_WARNING);
        set_error_handler("Saturn\\ErrorHandler::Notice", E_NOTICE);
    }
    public function Fatal($errno, $errstr, $errfile, $errline): void
    {
        echo out('<p style="color: red;">Fatal error: ' . $errstr . '</p>');
        exit;
    }

    public function Error($errno, $errstr, $errfile, $errline): void
    {
        echo out('<p style="color: red;">Error: ' . $errstr . '</p>');
        exit;
    }

    public function Warning($errno, $errstr, $errfile, $errline): void
    {
        echo out('<p style="color: yellow;">Warning: ' . $errstr . '</p>');
        exit;
    }

    public function Notice($errno, $errstr, $errfile, $errline): void
    {
        echo out('<p style="color: blue;">Notice: ' . $errstr . '</p>');
        exit;
    }
}