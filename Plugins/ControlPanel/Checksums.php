<?php

namespace ControlPanel;

class Checksums
{
    public function Validate()
    {
        $CoreSettings = hash_file('sha3-512', __DIR__.'/../../Settings/Settings.php');
        $CoreDeveloper = hash_file('sha3-512', __DIR__.'/../../Settings/Developer.php');
        $CoreTheme = hash_file('sha3-512', __DIR__.'/../../Settings/Theme.php');

        require_once __DIR__.'/Assets/ChkValues.php';
        if ($Checksum['CoreSettings'] !== $CoreSettings) {
            return false;
        }
        if ($Checksum['CoreDeveloper'] !== $CoreDeveloper) {
            return false;
        }
        if ($Checksum['CoreTheme'] !== $CoreTheme) {
            return false;
        }
    }

    public function Reset()
    {
        $CoreSettings = hash_file('sha3-512', __DIR__.'/../../Settings/Settings.php');
        $CoreDeveloper = hash_file('sha3-512', __DIR__.'/../../Settings/Developer.php');
        $CoreTheme = hash_file('sha3-512', __DIR__.'/../../Settings/Theme.php');
        $Data = '<?php $Checksum[\'CoreSettings\'] = \''.$CoreSettings.'\'; $Checksum[\'CoreDeveloper\'] = \''.$CoreDeveloper.'\'; $Checksum[\'CoreTheme\'] = \''.$CoreTheme.'\';';
        file_put_contents(__DIR__.'/Assets/ChkValues.php', $Data);
    }
}
