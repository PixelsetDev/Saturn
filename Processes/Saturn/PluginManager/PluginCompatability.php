<?php

namespace Saturn\PluginManager;

class PluginCompatability
{
    private object $Manifest;
    public function __construct($Manifest)
    {
        $this->Manifest = $Manifest;
    }
    public function Check(): array
    {
        if (!$this->CheckVersion()) { return ['Compatible' => false, 'Reason' => 'Not compatible with this version of Saturn.']; }
        if (!$this->CheckDuplicate()) { return ['Compatible' => false, 'Reason' => 'There are multiple versions of this plugin installed at the same time.']; }

        return ['Compatible' => true, 'Reason' => ''];
    }

    public function CheckVersion(): bool
    {
        foreach ($this->Manifest->Version->Saturn as $Version) {
            if ($Version === SATSYS_VERSION) {
                return true;
            }
        }

        return false;
    }

    public function CheckDuplicate(): bool
    {
        if (count(glob(__DIR__.'/../../../Plugins/' . '/*' . $this->Manifest->Slug)) == 1) {
            return true;
        } else {
            return true;
        }
    }

    public function CheckConflicts(): bool
    {
        if ($this->Manifest->Conflicts === false) {
            return true;
        } else {
            return false;
        }
    }
}