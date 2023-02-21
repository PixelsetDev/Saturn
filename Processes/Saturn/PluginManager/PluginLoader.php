<?php

namespace Saturn\PluginManager;

class PluginLoader
{
    public function LoadAll(): array
    {
        $SaturnPlugins = array();
        $Plugins = scandir(__DIR__ . '/../../../Plugins');
        foreach ($Plugins as $Plugin) {
            if ($Plugin != '.' && $Plugin != '..') {
                $Manifest = $this->GetManifest($Plugin);
                if ($Manifest != null) {
                    if ($this->ValidateManifest($Manifest)) {
                        if ($this->CheckCompatability($Manifest)) {
                            if ($this->HasDependencies($Manifest)) {
                                // TODO: ADD DEPENDENCY MANAGER
                            } else {
                                foreach ($Manifest->Startup as $Startup) {
                                    if (file_exists(__DIR__ . '/../../../Plugins/' . $Plugin . '/' . $Startup)) {
                                        require_once __DIR__ . '/../../../Plugins/' . $Plugin . '/' . $Startup;
                                        $SaturnPlugins[$Plugin]['Loaded'] = true;
                                    } else {
                                        $SaturnPlugins[$Plugin]['Loaded'] = false;
                                        $SaturnPlugins[$Plugin]['Loaded']['Reason'] = 'Startup file is missing.';
                                    }
                                }
                            }
                        } else {
                            $SaturnPlugins[$Plugin]['Loaded'] = false;
                            $SaturnPlugins[$Plugin]['Loaded']['Reason'] = 'Plugin is not compatible with this version of Saturn.';
                        }
                    } else {
                        $SaturnPlugins[$Plugin]['Loaded'] = false;
                        $SaturnPlugins[$Plugin]['Loaded']['Reason'] = 'Manifest file is corrupt.';
                    }
                } else {
                    $SaturnPlugins[$Plugin]['Loaded'] = false;
                    $SaturnPlugins[$Plugin]['Loaded']['Reason'] = 'Manifest file is missing.';
                }
            }
        }
        return $SaturnPlugins;
    }

    private function GetManifest(string $Plugin): object|null
    {
        if (file_exists(__DIR__ . '/../../../Plugins/' . $Plugin . '/Manifest.json')) {
            $Manifest = file_get_contents(__DIR__ . '/../../../Plugins/' . $Plugin . '/Manifest.json');
            return json_decode($Manifest);
        }
        return null;
    }

    private function CheckCompatability(object $Manifest): bool
    {
        $Compatible = false;

        foreach ($Manifest->Version->Saturn as $Version) {
            if ($Version == SATSYS_VERSION) {
                $Compatible = true;
            }
        }

        return $Compatible;
    }

    private function ValidateManifest(object $Manifest): bool
    {
        if (
            isset($Manifest->Name) &&
            isset($Manifest->Description) &&
            isset($Manifest->Author) &&
            isset($Manifest->Version->Plugin) &&
            isset($Manifest->Version->Saturn) &&
            isset($Manifest->Dependencies) &&
            isset($Manifest->Startup)
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function HasDependencies(object $Manifest): bool
    {
        if (count($Manifest->Dependencies) > 0) {
            return true;
        } else {
            return false;
        }
    }
}