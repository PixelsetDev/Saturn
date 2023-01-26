<?php
/**
 * Saturn Session Manager - Authenticate.
 *
 * Authenticates the session.
 */

namespace Saturn\SessionManager;

class Authenticate {
    function Login(string $username) {
        $_SESSION['username'] = $username;
        $_SESSION['token'] = password_hash($username, SECURITY_PASSWORD_ALGORITHM);
    }
}