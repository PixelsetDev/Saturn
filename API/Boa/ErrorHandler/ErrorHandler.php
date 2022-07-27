<?php

/**
 * Boa Error Handler Library
 * @author      Lewis Milburn <contact@lewismilburn.com>
 * @license     Apache-2.0 License
 */

namespace Boa\ErrorHandler;

use Boa\App;

class ErrorHandler extends App
{
    public array $settings;

    public function Error($message) {
        parent::__construct();

        $this->settings = parent::Settings();

        if($this->settings['show_errors']) {
            echo '[BOA > Error]: ' . $message;
        }
    }

    public function ErrorFatal($message) {
        global $settings;

        if($this->settings['show_fatal_errors']) {
            echo '[BOA > Fatal Error]: ' . $message;
            exit;
        }
    }
}