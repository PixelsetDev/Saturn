<?php

/**
 * Saturn Account Manager - Logout.
 *
 * Allows users to log out of Saturn.
 */

use Saturn\SessionManager\Session;

$Session = new Session();
$Session->End();

header('Location: '.SATURN_ROOT.'/account?success=logout');
