<?php

use Saturn\Saturn\HTTP\Router;

$Router = new Router();

$Router->GET('/', 'Processes/ViewManager/NoView.php');
