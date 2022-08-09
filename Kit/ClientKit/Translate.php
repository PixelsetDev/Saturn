<?php

namespace Saturn\ClientKit;

class Translate
{
    public string $Path;

    public function __construct(string $Path = __DIR__.'/../../Assets/Languages/')
    {
        $this->Path = $Path;
        if (file_exists($Path.'EN.json')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @since 1.0.0
     *
     * @author Lewis Milburn <lewis.milburn@lmwn.co.uk>
     *
     * @param string $Key
     *
     * @return string
     */
    public function TL(string $Key): string|object
    {
        $Translations = $this->GetTranslations(PANEL_LANGUAGE);

        if (!$Translations) {
            exit('There was an error loading the translations file. Saturn cannot run. Please use Saturn repair to fix this installation.');
        } else {
            if (property_exists($Translations, $Key)) {
                return $Translations->$Key;
            } else {
                return 'x';
            }
        }
    }

    /**
     * @since 1.0.0
     *
     * @author Lewis Milburn <lewis.milburn@lmwn.co.uk>
     *
     * @param string $Language
     *
     * @return mixed
     */
    private function GetTranslations(string $Language): mixed
    {
        $LanguageFile = $this->GetLanguageFile($Language);

        $Translations = json_decode($LanguageFile);

        return $Translations->Translations;
    }

    /**
     * @author Lewis Milburn <lewis.milburn@lmwn.co.uk>
     *
     * @since 1.0.0
     *
     * @param string $Language
     *
     * @return string|bool
     */
    private function GetLanguageFile(string $Language): string|bool
    {
        if (file_exists($this->Path.$Language.'.json')) {
            $LanguageFile = file_get_contents($this->Path.$Language.'.json');
        } else {
            if (file_exists($this->Path.'EN.json')) {
                echo 'Unable to load the requested language file. Loading fallback (english) instead.';
                $LanguageFile = file_get_contents($this->Path.'EN.json');
            } else {
                exit('Unable to load the language files. Saturn cannot run. Please use Saturn repair to fix this installation.');
            }
        }

        if ($LanguageFile !== false) {
            return $LanguageFile;
        } else {
            return false;
        }
    }
}
