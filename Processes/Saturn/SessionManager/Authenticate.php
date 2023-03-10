<?php
/**
 * Saturn Session Manager - Authenticate.
 *
 * Authenticates the session.
 */

namespace Saturn\SessionManager;

class Authenticate
{
    public function Login(string $username)
    {
        $_SESSION['username'] = $username;
        $_SESSION['token'] = password_hash($username.WEBSITE_SALT, SECURITY_TOKEN_ALGORITHM);
    }

    public function Authenticated(string $username, string $token): bool
    {
        if (!isset($username) && !isset($token)) {
            return false;
        }

        if ($token == password_hash($username.WEBSITE_SALT, SECURITY_TOKEN_ALGORITHM)) {
            return true;
        } else {
            return false;
        }
    }
}
