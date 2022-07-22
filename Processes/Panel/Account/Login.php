<?php

use Boa\App;
use Boa\Database\SQL;

echo 'Please wait...';

$App = new App();
$SQL = new SQL();

if ($SQL->Select('id', DATABASE_PREFIX.'users', '`username` = \''.$_POST['username'].'\'', 'NUMROWS') == 1) {
    echo 'User found';
} else {
    header('Location: index.php?status=0');
}

var_dump($_POST);