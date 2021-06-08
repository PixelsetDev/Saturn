<?php
    $foundTheme = false;
    $prefix = 'Saturn][Resource Loader][Themes';
    foreach (glob(dirname(__DIR__, 4)."/themes/*.php") as $filename) {
        include_once($filename);
        if (CONFIG_DEBUG === true) {
            log_console($prefix, 'Loaded Theme: '.$filename.'.');
        }
        $foundTheme = true;
    }
    if($foundTheme){
        if(CONFIG_DEBUG === true){
            log_console($prefix, 'Theme loading complete.');
        }
    } else {
        if(CONFIG_DEBUG === true){
            log_console($prefix, 'No themes found.');
        }
    }
    unset($foundTheme, $filename);