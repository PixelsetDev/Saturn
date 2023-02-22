<?php

namespace Saturn\HookManager;

use Exception;

class Actions {
    public function Register(string $ActionCode, string|array $Function, mixed $Data = null): void
    {
        global $ActionList;
        $ActionList[$ActionCode][] = array(['Function' => $Function, 'Data' => $Data]);
    }

    public function Unregister(string $ActionCode, string $Function): void
    {
        global $ActionList;
        foreach ($ActionList[$ActionCode] as $HookFunction) {
            if ($HookFunction['Function'] == $Function) {
                unset($HookFunction);
            }
        }
    }

    public function Run(string $ActionName): void
    {
        global $ActionList;
        if (!isset($ActionList[$ActionName])) {
            return;
        }

        foreach ($ActionList[$ActionName] as $ActionFunction) {
            try {
                call_user_func_array($ActionFunction[0]['Function'], $ActionFunction[0]['Data']);
            } catch (Exception) {}
        }
    }
}