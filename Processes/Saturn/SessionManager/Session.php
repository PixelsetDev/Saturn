<?php

/**
 * Saturn Session Manager - Start.
 *
 * Starts the session.
 */

namespace Saturn\SessionManager;

class Session
{
    public function Start(): void
    {
        session_start();
    }

    public function End(): void
    {
        unset($_SESSION['username']);
        unset($_SESSION['token']);
        session_unset();
        session_destroy();
    }
}
