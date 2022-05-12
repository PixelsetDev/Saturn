<?php

    global $conn;

    $query = 'SELECT `language` FROM `'.DATABASE_PREFIX.'users_settings` WHERE `id` = '.htmlspecialchars($_SESSION['id']);
    if ($query->num_rows != 0) {
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);
        $Language = $row['language'];
        if ($Language == NULL || $Language == 'DEFAULT') {
            $Language = CONFIG_LANGUAGE;
        }
    } else {
        echo '<script>console.log("'.date('Y/m/d H:i:s').' [SATURN][TRANSLATION] WARNING: Unable to access user language preference.");</script>';
        $Language = CONFIG_LANGUAGE;
    }

    $langJSON = file_get_contents(__DIR__.'/../../assets/lang/'.$Language.'.json');
    $lang = json_decode($langJSON);

    if ($lang->{'language'} != null || $lang->{'language'} != '') {
        if (CONFIG_DEBUG) {
            if ($lang->{'version'} != SATURN_VERSION) {
                echo '<script>console.log("'.date('Y/m/d H:i:s').' [SATURN][TRANSLATION] WARNING: Language file '.$lang->{'language'}.' is for Saturn version '.$lang->{'version'}.' - you are running version '.SATURN_VERSION.'");</script>';
            }
            echo '<script>console.log("'.date('Y/m/d H:i:s').' [SATURN][TRANSLATION] Loaded language file: '.$Language.'");</script>';
        }
    } else {
        if (CONFIG_DEBUG) {
            echo '<script>console.log("'.date('Y/m/d H:i:s').' [SATURN][TRANSLATION] Unable to load language file: '.$Language.'");</script>';
        }
        echo '<strong>FATAL ERROR: Unable to load language file: '.$Language.'</strong>';
    }

    function __($key): string
    {
        global $lang;
        if (isset($lang)) {
            // Select translation set
            if (strpos($key, 'Panel:') !== false) {
                $translations = $lang->translations->panel;
            } elseif (strpos($key, 'Admin:') !== false) {
                $translations = $lang->translations->admin;
            } elseif (strpos($key, 'Error:') !== false) {
                $translations = $lang->translations->error;
            } elseif (strpos($key, 'Security:') !== false) {
                $translations = $lang->translations->security;
            } else {
                $translations = $lang->translations->general;
            }
            // Select key
            $string = substr($key, strpos($key, ':') + 1);
            // Output translation
            if ($translations->$string == null || $translations->$string == '') {
                return __Fallback($key);
            } else {
                return $translations->$string;
            }
        } else {
            return 'Language file not loaded.';
        }
    }

    function __Fallback($key)
    {
        global $Language;

        $langJSON = file_get_contents(__DIR__.'/../../assets/lang/en-gb.json');
        $lang = json_decode($langJSON);

        if (isset($lang)) {
            // Select translation set
            if (strpos($key, 'Panel:') !== false) {
                $translations = $lang->translations->panel;
            } elseif (strpos($key, 'Admin:') !== false) {
                $translations = $lang->translations->admin;
            } elseif (strpos($key, 'Error:') !== false) {
                $translations = $lang->translations->error;
            } elseif (strpos($key, 'Security:') !== false) {
                $translations = $lang->translations->security;
            } else {
                $translations = $lang->translations->general;
            }
            // Select key
            $string = substr($key, strpos($key, ':') + 1);
            // Output translation
            if ($translations->$string == null || $translations->$string == '') {
                log_error('ERROR', 'Could not convert key '.$key.' into language '.$Language.' and no fallback translation was found, if this error persists please report it to contact@saturncms.net.');
                log_console('SATURN][TRANSLATION', 'Translation error. See error log for more information.');

                return $key;
            } else {
                if (LOGGING_ACTIVE) {
                    log_error('ERROR', 'Could not convert key '.$key.' into language '.$Language.' so the fallback translation into en-gb has been used.');
                    log_console('SATURN][TRANSLATION', 'Translation error. See error log for more information.');
                }

                return $translations->$string;
            }
        } else {
            return 'Language file not loaded.';
        }
    }
