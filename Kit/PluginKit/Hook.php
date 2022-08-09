<?php

namespace PluginKit;

class Hook
{
    private array $Hooks;

    public function __construct()
    {
        return true;
    }

    /**
     * @since 1.0.0
     *
     * @author Lewis Milburn <lewis.milburn@lmwn.co.uk>
     *
     * @param $Name
     * @param $Function
     *
     * @return bool
     */
    public function RegisterHook($Name, $Function): bool
    {
        $this->Hooks[$Name][] = $Function;
        return true;
    }

    /**
     * @since 1.0.0
     *
     * @author Lewis Milburn <lewis.milburn@lmwn.co.uk>
     *
     * @param $Name
     *
     * @return bool
     */
    public function ExecuteHook($Name): bool
    {
        foreach($this->Hooks[$Name] as $Function){
            call_user_func($Function);
        }
        return true;
    }
}