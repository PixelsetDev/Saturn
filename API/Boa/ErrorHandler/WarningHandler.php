<?php

/**
 * Boa Warning Handler Library
 * @author      Lewis Milburn <contact@lewismilburn.com>
 * @license     Apache-2.0 License
 */

namespace Boa\ErrorHandler;

use Boa\App;

class WarningHandler
{
    public function Warn($message) {
        $Boa = new App();
        $settings = $Boa->Settings();

        if($settings['show_warnings']) {
            echo '[BOA > Warning]: ' . $message;
        }
    }
}