<?php

namespace Saturn\PluginManager;

use Saturn\HookManager\Actions;

class PluginLoader
{
    public function Load(): void
    {
        $Actions = new Actions();

        $Actions->Run('Saturn.PluginLoader.PreLoad');

        $SaturnPlugins = [];
        $Plugins = scandir(__DIR__.'/../../../Plugins');

        $LOM = new PluginLoadOrder($Plugins);
        $Plugins = $LoadOrder = $LOM->GetLoadOrder();

        foreach ($Plugins as $Plugin) {
            $PM = new PluginManifest();
            $Manifest = $PM->GetManifest($Plugin);

            if ($Manifest == null) {
                $this->LoadStatus($Plugin, false, 'Manifest file is missing.');
                continue;
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
        }

        $Actions->Run('Saturn.PluginLoader.PostLoad');
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

    private function LoadStatus(string $Plugin, bool $Success, string|null $Reason = null): void
    {
        global $SaturnPlugins;
        $SaturnPlugins[$Plugin]['Loaded'] = $Success;
        if ($Reason != null) {
            $SaturnPlugins[$Plugin]['Reason'] = $Reason;
        }
    }
}