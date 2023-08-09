<?php

use ControlPanel\Checksums;

require_once __DIR__ . '/../../Checksums.php';

$Checksums = new Checksums();
if ($Checksums->Validate() === false) {
    header('Location: ' . SATURN_ROOT . '/panel/alert');
    exit;
}