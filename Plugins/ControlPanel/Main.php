<?php

use ControlPanel\CPRouter;
use Saturn\HTTP\Router;
use Saturn\LanguageManager\Translation;

var_dump($_SESSION);
require_once __DIR__.'/CPRouter.php';

function __CP(string $key): string
{
    $CPTranslate = new Translation(__DIR__.'/Assets/Languages/'.SATURN_LANGUAGE.'.json');

    return $CPTranslate->Translate($key);
}

$Router = new Router();

global $Actions;
$Actions->Register('RouteRegister', [new CPRouter(), 'Register'], [$Router]);
