<?php

namespace Saturn\LanguageManager;

use Saturn\ErrorHandler;

class Translation
{

    private string $LanguageFile;

    public function __construct($LanguageFile = null)
    {
        if ($LanguageFile != null) {
            $this->LanguageFile = $LanguageFile;
        } else {
            $this->LanguageFile = __DIR__.'/../../../Assets/Languages/'.SATURN_LANGUAGE.'.json';
        }
    }

    public function Translate(string $key): string|bool
    {
        if (file_exists($this->LanguageFile)) {
            $LanguageFile = file_get_contents($this->LanguageFile);

            return $this->DoTranslation($LanguageFile, $key);
        } else {
            $ErrorHandler = new ErrorHandler();
            $ErrorHandler->Fatal('1', 'Language file not found at '.$this->LanguageFile, 'Translation.php', '23');
        }
        return false;
    }

    public function DoTranslation(string $LanguageFile, string $key)
    {
        $LanguageJSON = json_decode($LanguageFile);

        return $LanguageJSON->$key ?? $key ?? 'Unknown';
    }
}
