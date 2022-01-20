<?php

    $langJSON = file_get_contents(__DIR__.'/../../../assets/lang/'.CONFIG_LANGUAGE.'.json');
    $lang = json_decode($langJSON);
    if ($lang->{'language'} != null || $lang->{'language'} != '') {
        if (CONFIG_DEBUG) {
            if ($lang->{'version'} != SATURN_VERSION) {
                log_console('SATURN][RERL][TRANSLATION', 'WARNING: Language file '.$lang->{'language'}.' is for Saturn version '.$lang->{'version'}.' - you are running version '.SATURN_VERSION);
            }
            log_console('SATURN][RERL][TRANSLATION', 'Loaded language file: '.$lang->{'language'});
        }
    } else {
        if (CONFIG_DEBUG) {
            log_console('SATURN][RERL][THEMES', 'Unable to load language file: '.CONFIG_LANGUAGE);
        }
        echo alert('ERROR', 'Unable to load language file: '.CONFIG_LANGUAGE);
        log_error('ERROR', 'Unable to load language file: '.CONFIG_LANGUAGE);
    }
