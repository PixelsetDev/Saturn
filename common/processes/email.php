<?php

    function send_email($email, $subject, $message): bool
    {
        $email = checkInput('DEFAULT', $email);
        $subject = checkInput('DEFAULT', $subject);
        $message = checkInput('HTML', $message);

        $message = stripslashes($message);
        if (CONFIG_EMAIL_FUNCTION == 'phpmail') {
            $to = $email;
            if (!isset($to)) {
                echo alert('Email error: No recipient.');

                return false;
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
        <div class="w-full h-auto bg-gray-100 py-2 px-4 mb-4 flex">
            <img src="https://service.lmwn.co.uk/brandkit/saturn/logo.png" class="w-1/4 h-auto float-left" alt="Saturn">
            <span class="flex-grow text-right self-center text-4xl">'.CONFIG_SITE_NAME.'</span>
        </div>
        <div class="py-2 px-4">'.$message.'</div>
        <div class="py-20 px-4 text-xs italic">'.__('General:Email_Footer').' '.CONFIG_SITE_NAME.' '.__('General:Email_Footer_2').' '.$_SERVER['SERVER_NAME'].'. '.__('General:Email_Footer_3').'</div>
    </body>
</html>';

            return mail($to, $subject, $contents, $headers);
        } elseif (CONFIG_EMAIL_FUNCTION == strtolower('smtp')) {
            echo __('Error:Fatal').': '.__('Error:SMTP_1').SATURN_VERSION.__('Error:SMTP_2');
            log_error(__('Error:Fatal'), __('Error:SMTP_1').SATURN_VERSION.__('Error:SMTP_2'));
            exit;
        } else {
            echo __('Error:Fatal').': '.__('Error:EmailFunction_1').SATURN_VERSION.__('Error:EmailFunction_2');
            log_error(__('Error:Fatal'), __('Error:EmailFunction_1').SATURN_VERSION.__('Error:EmailFunction_2'));
            exit;
        }
    }
