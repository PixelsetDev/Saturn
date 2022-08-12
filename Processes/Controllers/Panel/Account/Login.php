<?php

use Saturn\ClientKit\Authentication;

global $API_LOCATION;

require_once __DIR__ . '/../../../../Kit/ClientKit/ClientKit.php';

$Auth = new Authentication();

$Result = $Auth->DoLogin($_POST['username'], $_POST['password']);

if ($Result == 1) {
    header('Location: /account/?Error=1');
} elseif ($Result == 2) {
    header('Location: /account/?Error=2');
} elseif (isset($Result[0]['id'])) {
    $_SESSION['token'] = 'ACTIVE';
    $_SESSION['username'] = $Result[0]['username'];
    $_SESSION['role'] = $Result[0]['role'];
    header('Location: /panel');
} else {
    header('Location: /account/?Error=-1');
}