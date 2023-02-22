<?php

namespace Saturn\PluginManager;

use Saturn\HookManager\Actions;

class PluginLoader
{
    public function LoadSpecific(mixed $Plugin): bool
    {
        if ($Plugin == '.' || $Plugin == '..') {
            return false;
        }

        $Manifest = $this->GetManifest($Plugin);
        if ($Manifest == null) {
            $this->LoadStatus($Plugin, false, 'Manifest file is missing.');

            return false;
        }

        if ($this->ValidateManifest($Manifest)) {
            if ($this->CheckCompatability($Manifest)) {
                foreach ($Manifest->Startup as $Startup) {
                    if (file_exists(__DIR__.'/../../../Plugins/'.$Plugin.'/'.$Startup)) {
                        require_once __DIR__.'/../../../Plugins/'.$Plugin.'/'.$Startup;
                        $this->LoadStatus($Plugin, true);
                    } else {
                        $this->LoadStatus($Plugin, false, 'Startup file is missing.');
                    }
                }
            } else {
                $this->LoadStatus($Plugin, false, 'Plugin is not compatible with this version of Saturn.');
            }
        } else {
            $this->LoadStatus($Plugin, false, 'Manifest file is corrupt.');
        }

        return true;
    }

    public function LoadAll(): void
    {
        $Actions = new Actions();

        $SaturnPlugins = [];
        $Plugins = scandir(__DIR__.'/../../../Plugins');

        foreach ($Plugins as $Plugin) {
            if ($Plugin == '.' || $Plugin == '..') {
                continue;
            }

            $Manifest = $this->GetManifest($Plugin);
            if ($Manifest == null) {
                $this->LoadStatus($Plugin, false, 'Manifest file is missing.');
                continue;
            }

            if ($this->ValidateManifest($Manifest)) {
                if ($this->CheckCompatability($Manifest)) {
                    if ($this->HasDependencies($Manifest)) {
                        $Actions->Register('Saturn.PluginManager.LoadedNonDepends', [new PluginLoader(), 'LoadSpecific'], [$Plugin]);
                    } else {
                        foreach ($Manifest->Startup as $Startup) {
                            if (file_exists(__DIR__.'/../../../Plugins/'.$Plugin.'/'.$Startup)) {
                                require_once __DIR__.'/../../../Plugins/'.$Plugin.'/'.$Startup;
                                $this->LoadStatus($Plugin, true);
                            } else {
                                $this->LoadStatus($Plugin, false, 'Startup file is missing.');
                            }
                        }
                    }
                } else {
                    $this->LoadStatus($Plugin, false, 'Plugin is not compatible with this version of Saturn.');
                }
            } else {
                $this->LoadStatus($Plugin, false, 'Manifest file is corrupt.');
            }
        }

        $Actions->Run('Saturn.PluginManager.LoadedNonDepends');
    }

    private function GetManifest(string $Plugin): object|null
    {
        if (file_exists(__DIR__.'/../../../Plugins/'.$Plugin.'/Manifest.json')) {
            $Manifest = file_get_contents(__DIR__.'/../../../Plugins/'.$Plugin.'/Manifest.json');

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

    private function LoadStatus(string $Plugin, bool $Success, string|null $Reason = null): void
    {
        global $SaturnPlugins;
        $SaturnPlugins[$Plugin]['Loaded'] = $Success;
        if ($Reason != null) {
            $SaturnPlugins[$Plugin]['Reason'] = $Reason;
        }
    }
}
