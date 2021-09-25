<?php

ob_start();
session_start();
$user = $_SESSION['id'];
require_once __DIR__.'/../team/profile/index.php';
ob_end_flush();
