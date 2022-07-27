<?php

namespace SaturnServer\Notifications;

use Boa\App;
use Boa\Email\PHPMail;

class Email
{
    /**
     * Send emails from the Saturn Server.
     *
     * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
     * @license     Apache 2.0
     *
     * @since       1.0.0
     *
     * @version     1.0.0
     *
     * @param string      $to
     * @param string      $subject
     * @param string      $message
     * @param string|null $replyto
     * @param string|null $cc
     * @param string|null $bcc
     *
     * @return bool|void
     */
    public function sendMail(string $to, string $subject, string $message, string $replyto = null, string $cc = null, string $bcc = null)
    {
        new App();
        $Email = new PHPMail();
        $Email->sendMail($to, EMAIL_SENDFROM, $subject, $message, $replyto, $cc, $bcc);

        return true;
    }
}
