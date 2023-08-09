<?php

/**
 * Saturn Account Manager - UUID.
 *
 * Generate unique user IDs.
 */

namespace Saturn\AccountManager;

use Saturn\ErrorHandler;

class UUID
{
    function Generate($Length = 13)
    {
        if (function_exists("random_bytes")) {
            $RandomBytes = random_bytes(ceil($Length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $RandomBytes = openssl_random_pseudo_bytes(ceil($Length / 2));
        } else {
            $EH = new ErrorHandler();
            $EH->SaturnError(
                '500',
                'SAT-4',
                'Function not found.',
                'No cryptographically secure algorithms are available. One or more of following algorithms are required but are not enabled in your PHP installation: random_bytes OR openssl_random_pseudo_bytes.',
                SATSYS_DOCS_URL.'/troubleshooting/errors/saturn#sat-4'
            );
        }
        return substr(bin2hex($RandomBytes), 0, $Length);
    }
}