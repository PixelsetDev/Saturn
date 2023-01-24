<?php

namespace Saturn;

class Translation
{
    public function Translate(string $key)
    {
        if (file_exists(__DIR__.'/../../Assets/Languages/'.WEBSITE_LANGUAGE.'.json')) {
            $LanguageFile = file_get_contents(__DIR__.'/../../Assets/Languages/'.WEBSITE_LANGUAGE.'.json');

            return $this->DoTranslation($LanguageFile, $key);
        } elseif (file_exists(__DIR__.'/../../Assets/Languages/en-gb.json')) {
            $LanguageFile = file_get_contents(__DIR__.'/../../Assets/Languages/en-gb.json');

            return $this->DoTranslation($LanguageFile, $key);
        } else {
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->Fatal('1', 'Language file not found at /../../Assets/Languages/'.WEBSITE_LANGUAGE.'.json', 'Translation.php', '21');
        }
    }

    public function DoTranslation(string $LanguageFile, string $key)
    {
        $LanguageJSON = json_decode($LanguageFile);

        if (isset($LanguageJSON->$key)) {
            return $LanguageJSON->$key;
        } else {
            return $key;
        }
    }
}
