<?php

use ControlPanel\CPRouter;
use Saturn\HookManager\Actions;
use Saturn\HTTP\Router;
use Saturn\LanguageManager\Translation;

require_once __DIR__.'/CPURLs.php';
require_once __DIR__.'/CPRouter.php';

$Actions = new Actions();
$Actions->Run('ControlPanel.Start');

function __CP(string $Key): string
{
    $CPTranslate = new Translation(__DIR__.'/Assets/Languages/'.SATURN_LANGUAGE.'.json');

    return $CPTranslate->Translate($Key);
}

$Router = new Router();
$Actions->Register('RouteRegister', [new CPRouter(), 'Register'], [$Router]);

$Actions->Run('ControlPanel.End');
