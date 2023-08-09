<?php

use ControlPanel\CPRouter;
use Saturn\HookManager\Actions;
use Saturn\HTTP\Router;
use Saturn\LanguageManager\Translation;

require_once __DIR__.'/CPRouter.php';

$Actions = new Actions();
$Actions->Run('ControlPanel.Start');

function __CP(string $key): string
{
    $CPTranslate = new Translation(__DIR__.'/Assets/Languages/'.SATURN_LANGUAGE.'.json');

    return $CPTranslate->Translate($key);
}

$Router = new Router();
$Actions->Register('RouteRegister', [new CPRouter(), 'Register'], [$Router]);

$Actions->Run('ControlPanel.End');
