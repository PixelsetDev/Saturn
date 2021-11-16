<?php

    $themeDataJSON = file_get_contents(__DIR__.'/../../../themes/'.THEME_SLUG.'/theme.json');
    $themeData = json_decode($themeDataJSON);
    if ($themeData->{'theme'}->{'name'} != null || $themeData->{'theme'}->{'name'} != '') {
        if (CONFIG_DEBUG) {
            if ($themeData->{'theme'}->{'version'}->{'saturn'} != SATURN_VERSION) {
                log_console('SATURN][RESOURCE LOADER][THEMES', 'WARNING: Theme '.$themeData->{'theme'}->{'name'}.' is for Saturn version '.$themeData->{'theme'}->{'version'}->{'saturn'}.' - you are running version '.SATURN_VERSION);
            }
            log_console('SATURN][RESOURCE LOADER][THEMES', 'Loaded theme: '.$themeData->{'theme'}->{'name'});
        }
    } else {
        if (CONFIG_DEBUG) {
            log_console('SATURN][RESOURCE LOADER][THEMES', 'Unable to load theme: '.THEME_SLUG);
        }
        echo alert('ERROR', 'Unable to load theme: '.THEME_SLUG);
        log_error('ERROR', 'Unable to load theme: '.THEME_SLUG);
    }
