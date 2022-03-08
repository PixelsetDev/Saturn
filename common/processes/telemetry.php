<?php

function send_data(): string
{
    if (CONFIG_SEND_DATA) {
        $data = [
            'key'            => urlencode(CONFIG_ACTIVATION_KEY),
            'saturn_version' => urlencode(SATURN_VERSION),
            'php_version'    => urlencode(PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION),
            'server_os'      => urlencode(PHP_OS_FAMILY),
        ];
        if (activation_validate()) {
            $telemetry = 'https://link.saturncms.net/telemetry/?key='.$data['key'].'&saturn_version='.$data['saturn_version'].'&php_version='.$data['php_version'].'&server_os='.$data['server_os'];

            return file_get_contents($telemetry);
        } else {
            return '0';
        }
    } else {
        return '0';
    }
}
