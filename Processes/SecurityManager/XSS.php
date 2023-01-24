<?php

/**
 * Saturn Security Manager - XSS
 *
 * Prevents cross-site scripting.
 *
 * By PHPRouter - MIT License (https://github.com/phprouter/main/blob/main/LICENSE)
 */

namespace Saturn\SecurityManager;

class XSS
{
    public function out($text): void
    {
        echo htmlspecialchars($text);
    }
}