<?php

    function send_email($email, $subject, $message)
    {
        if (CONFIG_EMAIL_FUNCTION == 'phpmail') {
            $to = $email;
            if (!isset($to)) {
                echo 'Email error: No recipient.';
                exit;
            }
            $headers = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type:text/html;charset=UTF-8'."\r\n";
            $headers .= 'From: '.CONFIG_EMAIL_SENDFROM."\r\n";
            $contents = '<html lang="en">
    <head>
        <title>'.$subject.'</title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="w-full h-auto bg-gray-100 py-1 px-4 mb-4">
            <img src="https://service.lmwn.co.uk/brandkit/saturn/logo.png" class="w-1/2" alt="Saturn">
        </div>
        <div>'.$message.'</div>
        <div class="mt-20 text-xs italic">This message was sent because you have an account registered with a Saturn installation at "'.CONFIG_SITE_NAME.'". You may be able to opt-out of these emails in your user settings.</div>
    </body>
</html>';
            mail($to, $subject, $contents, $headers);
        } elseif (CONFIG_EMAIL_FUNCTION == 'smtp') {
            echo 'SMTP is not implemented.';
        }
    }
