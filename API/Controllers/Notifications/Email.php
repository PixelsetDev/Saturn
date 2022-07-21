<?php

namespace SaturnAPI\Notifications;

use Boa\App;
use Boa\Email\PHPMail;

class Email
{
    public function sendMail(string $to, string $subject, string $message, string $replyto = null, string $cc = null, string $bcc = null) {
        new App();
        $Email = new PHPMail;
        return $Email->sendMail($to, EMAIL_SENDFROM, $subject, $message, $replyto, $cc, $bcc);
    }
}