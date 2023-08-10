<?php

namespace Saturn\PluginManager;

use Saturn\HookManager\Actions;

class PluginLoader
{
    public function Load(): void
    {
        $Actions = new Actions();

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

            if ($Manifest->Hibernate !== false) {
                $Hibernate = new Hibernate();
                if ($Hibernate->Hibernate($Manifest)) {
                    $this->LoadStatus($Plugin, false, 'Plugin is hibernating. It will load and be ready to use when needed.');
                    continue;
                }
            }

            if ($this->ValidateManifest($Manifest)) {
                $PluginCompatability = new PluginCompatability($Manifest);
                $Compatible = $PluginCompatability->Check();
                if ($Compatible['Compatible']) {
                    foreach ($Manifest->Startup as $Startup) {
                        if (file_exists(__DIR__.'/../../../Plugins/'.$Plugin.'/'.$Startup)) {
                            require_once __DIR__.'/../../../Plugins/'.$Plugin.'/'.$Startup;
                            $this->LoadStatus($Plugin, true);
                        } else {
                            $this->LoadStatus($Plugin, false, 'Startup file is missing.');
                        }
                    }
                } else {
                    $this->LoadStatus($Plugin, false, $Compatible['Reason']);
                }
            } else {
                $this->LoadStatus($Plugin, false, 'Manifest file is corrupt.');
            }
        }

        $Actions->Run('Saturn.PluginLoader.PostLoad');
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

    public function PluginLoaded(string $Plugin): bool
    {
        global $SaturnPlugins;
        if ($SaturnPlugins[$Plugin]['Loaded']) {
            return true;
        }

        return false;
    }
}
