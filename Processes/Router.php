<?php

use Saturn\RouteManager\Routes;
echo 2;
require_once __DIR__ . '/Saturn/RouteManager/Routes.php';
echo 2;
$Routes = new Routes();
echo 3;
$Routes->Register();
echo 4;