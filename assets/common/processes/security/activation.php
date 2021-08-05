<?php

    function activation_validate(): bool
    {
        $activation_key = file_get_contents("https://link.saturncms.net/?key_status=" . CONFIG_ACTIVATION_KEY);
        $activation_key_url = file_get_contents("https://link.saturncms.net/?key_registered_url=" . CONFIG_ACTIVATION_KEY);
        if ($activation_key == '1' && $activation_key_url == $_SERVER['HTTP_HOST']) {
            return true;
        } else {
            echo '<div class="bg-yellow-100 border-l-4 border-yellow-500 hover:-translate-y-2">
                                    <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                        <h6 class="mb-2 font-semibold leading-5">[WARNING] Activation: Saturn is not activated, certain features may be unavailable. You can still use some features of Saturn unactivated. You can activate Saturn in your Admin Panel. <a href="https://docs.saturncms.net/activation" class="underline text-xs text-black" target="_blank">Get help.</a></h6>
                                    </div>
                                </div>';
            log_console('SATURN][ACTIVATION','Saturn is not activated, certain features may be unavailable. You can still use some features of Saturn unactivated. You can activate Saturn in your Admin Panel.');
            return false;
        }
    }