<?php

namespace Saturn\PluginManager;

class PluginLoadOrder
{
    private array $LoadOrder;
    public function __construct(array $Plugins)
    {
        $this->LoadOrder = $Plugins;
    }

    public function GetLoadOrder(): array
    {
        $this->SortLoadOrder();
        return $this->LoadOrder;
    }

    private function SortLoadOrder(): void {
        foreach ($this->LoadOrder as $Plugin) {
            if ($Plugin == '.' || $Plugin == '..') {
                unset($this->LoadOrder[array_search($Plugin, $this->LoadOrder)]);
            } else {
                $PM = new PluginManifest();

                $Manifest = $PM->GetManifest($Plugin);

                if ($Manifest->Dependencies != null) {
                    foreach ($Manifest->Dependencies as $Dependency) {
                        if (in_array($Dependency, $this->LoadOrder)) {
                            $DependencyIndex = array_search($Dependency, $this->LoadOrder);
                            $PluginIndex = array_search($Plugin, $this->LoadOrder);
                            if ($DependencyIndex > $PluginIndex) {
                                $this->LoadOrder[$PluginIndex] = $Dependency;
                                $this->LoadOrder[$DependencyIndex] = $Plugin;
                            }
                        }
                    }
                }
            }
        }
    }
}