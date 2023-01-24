<?php

/**
 * Saturn Security Manager - CSRF.
 *
 * Prevents cross-site request forgery.
 *
 * By PHPRouter - MIT License (https://github.com/phprouter/main/blob/main/LICENSE)
 */

namespace Saturn\SecurityManager;

class CSRF
{
    public function set_csrf(): void
    {
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(50));
        }
        echo '<input type="hidden" name="csrf" value="'.$_SESSION['csrf'].'">';
    }

    public function is_csrf_valid(): bool
    {
        if (!isset($_SESSION['csrf']) || !isset($_POST['csrf'])) {
            return false;
        }
        if ($_SESSION['csrf'] != $_POST['csrf']) {
            return false;
        }

        return true;
    }
}
