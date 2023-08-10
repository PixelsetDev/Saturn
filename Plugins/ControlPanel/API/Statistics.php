<?php

use Saturn\DatabaseManager\DBMS;

$DB = new DBMS();

$DB->Select('*','pages','1', 'all:num');

echo '{"pages":'.$DB->RowCount().'}';