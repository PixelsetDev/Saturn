<?php
/**
 * Saturn Session Manager - Authenticate.
 *
 * Authenticates the session.
 */

namespace Saturn\SessionManager;

class Authenticate
{
    public function Login(string $Username, string $UUID): void
    {
        $_SESSION['username'] = $Username;
        $_SESSION['uuid'] = $UUID;
        $_SESSION['token'] = password_hash($Username.WEBSITE_SALT, SECURITY_TOKEN_ALGORITHM);
    }

    public function Validate(string $username, string $token): bool
    {
        if (!isset($username) && !isset($token)) {
            return false;
        }

        if (password_verify($username.WEBSITE_SALT, $token)) {
            return true;
        } else {
            return false;
        }
    }
}
