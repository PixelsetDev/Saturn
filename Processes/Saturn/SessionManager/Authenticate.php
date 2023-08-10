<?php
/**
 * Saturn Session Manager - Authenticate.
 *
 * Authenticates the session.
 */

namespace Saturn\SessionManager;

class Authenticate
{
    public function Generate(string $Username, string $UUID): void
    {
        $_SESSION['Username'] = $Username;
        $_SESSION['UUID'] = $UUID;
        $_SESSION['Token'] = password_hash($Username.$UUID.WEBSITE_SALT, SECURITY_TOKEN_ALGORITHM);
    }

    public function Validate(): bool
    {
        $Username = $_SESSION['Username'];
        $UUID = $_SESSION['UUID'];
        $Token = $_SESSION['Token'];

        if (!empty($Username) && !empty($UUID) && !empty($Token)) {
            return false;
        }

        if (password_verify($Username.$UUID.WEBSITE_SALT, $Token)) {
            return true;
        } else {
            return false;
        }
    }
}
