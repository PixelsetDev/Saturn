<?php
$foundTheme = false;
    foreach (glob(dirname(__DIR__, 4)."/themes/*.php") as $filename) {
        include_once($filename);
        if (CONFIG_DEBUG === true) {
            log_console('Saturn][Resource Loader][Themes', 'Loaded Theme: '.$filename.'.');
        }
        $foundTheme = true;
    }
    if($foundTheme){
        if(CONFIG_DEBUG === true){
            log_console('Saturn][Resource Loader][Themes', 'Theme loading complete.');
        }
    } else {
        if(CONFIG_DEBUG === true){
            log_console('Saturn][Resource Loader][Themes', 'No themes found.');
        }
    }
    unset($foundTheme, $filename);