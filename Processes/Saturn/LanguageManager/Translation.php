<?php

namespace Saturn\LanguageManager;

use Saturn\ErrorHandler;

class Translation
{
    public function Translate(string $key): string|bool
    {
        if (file_exists(__DIR__.'/../../../Assets/Languages/'.SATURN_LANGUAGE.'.json')) {
            $LanguageFile = file_get_contents(__DIR__.'/../../../Assets/Languages/'.SATURN_LANGUAGE.'.json');

            return $this->DoTranslation($LanguageFile, $key);
        } elseif (file_exists(__DIR__.'/../../../Assets/Languages/en-gb.json')) {
            $LanguageFile = file_get_contents(__DIR__.'/../../../Assets/Languages/en-gb.json');

            return $this->DoTranslation($LanguageFile, $key);
        } else {
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->Fatal('1', 'Language file not found at /../../Assets/Languages/'.SATURN_LANGUAGE.'.json', 'Translation.php', '21');
        }
        return false;
    }

    public function DoTranslation(string $LanguageFile, string $key)
    {
        $LanguageJSON = json_decode($LanguageFile);

        return $LanguageJSON->$key ?? $key ?? 'Unknown';
    }
}
