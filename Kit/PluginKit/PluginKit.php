<?php

namespace Saturn;

class PluginKit
{
    /**
     * @since 1.0.0
     * @var array
     */
    public array $Hooks;

    /**
     * @since 1.0.0
     *
     * @author Lewis Milburn <lewis.milburn@lmwn.co.uk>
     */
    public function __construct()
    {
        $this->Hooks = array();
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
        if (array_key_exists($Name, $this->Hooks)) {
            foreach($this->Hooks[$Name] as $Function){
                call_user_func($Function);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @since 1.0.0
     *
     * @author Lewis Milburn <lewis.milburn@lmwn.co.uk>
     *
     * @param $Filename
     *
     * @return string
     */
    static public function GetPluginName($Filename): string
    {
        $Directories = explode('/', $Filename);
        $NumKeys = array_key_last($Directories) - 1;
        return $Directories[$NumKeys];
    }

    /**
     * @since 1.0.0
     *
     * @author Lewis Milburn <lewis.milburn@lmwn.co.uk>
     *
     * @param $Filename
     *
     * @return string
     */
    static public function GetFileName($Filename): string
    {
        $Directories = explode('/', $Filename);
        $NumKeys = array_key_last($Directories);
        $FileName = explode('.', $Directories[$NumKeys]);
        return $FileName[0];
    }
}