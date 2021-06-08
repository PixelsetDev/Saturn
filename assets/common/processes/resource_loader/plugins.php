<?php
    $foundPlugin = false;
    foreach (glob(dirname(__DIR__, 4)."/plugins/*.php") as $filename) {
        include_once($filename);
        if (CONFIG_DEBUG === true) {
            log_console('Saturn][Resource Loader][Plugins', 'Loaded Plugin: '.substr($filename, strpos($filename, "plugins") + 8));
        }
        $foundPlugin = true;
    }
    if($foundPlugin){
        if(CONFIG_DEBUG === true){
            log_console('Saturn][Resource Loader][Plugins', 'Plugin loading complete.');
        }
    } else {
        if(CONFIG_DEBUG === true){
            log_console('Saturn][Resource Loader][Plugins', 'No plugins found.');
        }
    }
    unset($foundPlugin, $filename);