<?php

    function listActivePlugins() {
        $found=false;
        foreach (glob(dirname(__DIR__, 4)."/plugins/*.php") as $filename) {
            $plugin = substr($filename, strpos($filename, "plugins") + 8);
            $plugin = str_replace(".php", "", $plugin);
            echo ucfirst($plugin);
            if($found==true) {
                echo ', ';
            }
            $found=true;
        }
    }

    $foundPlugin = false;
    $prefix = 'Saturn][Resource Loader][Plugins';
    foreach (glob(dirname(__DIR__, 4)."/plugins/*.php") as $filename) {
        include_once($filename);
        if (CONFIG_DEBUG === true) {
            log_console($prefix, 'Loaded Plugin: '.substr($filename, strpos($filename, "plugins") + 8));
        }
        $foundPlugin = true;
    }

    if($foundPlugin){
        if(CONFIG_DEBUG === true){
            log_console($prefix, 'Plugin loading complete.');
        }
    } else {
        if(CONFIG_DEBUG === true){
            log_console($prefix, 'No plugins found.');
        }
    }
    unset($foundPlugin, $filename);