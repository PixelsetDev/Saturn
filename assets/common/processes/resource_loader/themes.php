<?php
    $themeDataJSON = file_get_contents(__DIR__ . '/../../../../themes/' . THEME_SLUG . '/theme.json');
    $themeData = json_decode($themeDataJSON);
    if ($themeData->{'theme'}->{'name'} != null || $themeData->{'theme'}->{'name'} != '') {
        if (CONFIG_DEBUG) {log_console('SATURN][RESOURCE LOADER][THEMES', 'Loaded theme: ' . $themeData->{'theme'}->{'name'}); }
    } else {
        if (CONFIG_DEBUG) {log_console('SATURN][RESOURCE LOADER][THEMES', 'Unable to load theme: ' . THEME_SLUG); }
        echo alert('ERROR','Unable to load theme: ' . THEME_SLUG);
    }