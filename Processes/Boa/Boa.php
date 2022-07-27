<?php

/**
 * Boa - The simple, fast and reliable PHP Framework.
 * @author      Lewis Milburn <contact@lewismilburn.com>
 * @license     Apache-2.0 License
 */

namespace Boa;

use Exception;

class App {

    public array $settings;
    private string $version = '1.0.0';

    public function Settings(): array {
        return array (
            // Error Handling
            'show_warnings' => BOA_SHOW_WARNINGS,
            'show_errors' => BOA_SHOW_ERRORS,
            'show_fatal_errors' => BOA_SHOW_FATAL_ERRORS,
            'update_check' => BOA_UPDATE_CHECK
        );
    }

    public function __construct()
    {
        // Load external settings
        if (file_exists(__DIR__ . '/../../Settings.php')) {
            require_once __DIR__ . '/../../Settings.php';
        } else {
            die('Unable to locate Settings.php file.');
        }

        $this->settings = $this->Settings(); // Register local settings
        $this->Autoload(); // Register modules

        if ($this->settings['update_check'] && $this->settings['show_warnings'] && $this->UpdateCheck()) {
            echo 'WARN: A new version of Boa can be downloaded. Visit https://github.com/lewmilburn/boa/releases for more information.';
        }
    }

    public function Autoload(): void
    {
        // Get modules list
        $modulesJSON = $this->Modules();
        $i=1;
        // Loop through the modules.
        foreach ($modulesJSON as $module) {
            try {
                // If enabled, load 'em up!
                if ($module->enabled == 'true') {
                    require_once __DIR__ . $module->module;
                }
                // On to the next one...
                $i++;
            } catch(Exception) {
                // Oh dear... moving on.
                $i++;
            }
        }
    }

    public function Modules() {
        $modulesJSON = file_get_contents(__DIR__ . '/modules.json');
        return json_decode($modulesJSON);
    }

    public function UpdateCheck(): bool
    {
        $latest = file_get_contents('https://lewismilburn.com/boa/version.txt');
        if ($latest > $this->version) {
            return true;
        } else {
            return false;
        }
    }
}