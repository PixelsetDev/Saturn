<?php

namespace Saturn\PluginManager;

class PluginManifest
{
    public function GetManifest(string $Plugin): object|null
    {
        if (file_exists(__DIR__.'/../../../Plugins/'.$Plugin.'/Manifest.json')) {
            $Manifest = file_get_contents(__DIR__.'/../../../Plugins/'.$Plugin.'/Manifest.json');

            return json_decode($Manifest);
        }

        return null;
    }
}
