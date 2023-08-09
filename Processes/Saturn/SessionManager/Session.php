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
}
