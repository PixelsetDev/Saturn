<?php

/**
 * Boa PHPMail Library
 * @author      Lewis Milburn <contact@lewismilburn.com>
 * @license     Apache-2.0 License
 */

namespace Boa\Email;

use Boa\App;

class PHPMail extends App
{
    public function __construct()
    {
        parent::__construct();
    }

    public function sendMail(string $to, string $from, string $subject, string $message, string $replyto = null, string $cc = null, string $bcc = null) {
        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Additional headers
        $headers[] = 'To: '.$to;
        $headers[] = 'From: '.$from;
        if(!is_null($cc)) { $headers[] = 'Cc: ' . $cc; }
        if(!is_null($bcc)) { $headers[] = 'Bcc: ' . $bcc; }
        if(!is_null($replyto)) { $headers[] = 'Reply-To: ' . $replyto; }
        $headers[] = 'X-Mailer: PHP/' . phpversion();

        // Mail it
        mail($to, $subject, $message, implode("\r\n", $headers));
    }
}