<?php

namespace PluginKit;

class Load
{
    public function __construct()
    {
        foreach (glob(__DIR__.'/../../Plugins/*.php') as $filename) {
            include $filename;
        }
    }
}
