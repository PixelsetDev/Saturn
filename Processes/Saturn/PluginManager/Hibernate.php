<?php

namespace Saturn\PluginManager;

class Hibernate
{
    public function Hibernate($Manifest): bool
    {
        foreach ($Manifest->Hibernate as $Hibernate) {
            return $this->URL($Hibernate);
        }

        return false;
    }

    public function URL($URL): bool
    {
        if (str_contains($_SERVER['REQUEST_URI'], $URL)) {
            return false;
        }

        return true;
    }
}
