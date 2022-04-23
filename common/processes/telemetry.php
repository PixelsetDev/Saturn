<?php

function Telemetry(): string
{
    if (CONFIG_SEND_DATA && CONFIG_ACTIVATION_KEY != null) {
        $data = [
            'key'            => urlencode(CONFIG_ACTIVATION_KEY),
            'saturn_version' => urlencode(SATURN_VERSION),
            'saturn_branch'  => urlencode(SATURN_BRANCH),
            'php_version'    => urlencode(PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION),
            'server_os'      => urlencode(PHP_OS_FAMILY),
        ];
        if (activation_validate()) {
            try {
                $telemetry = 'https://link.saturncms.net/telemetry/?key='.$data['key'].'&saturn_version='.$data['saturn_version'].'&saturn_branch='.$data['saturn_branch'].'&php_version='.$data['php_version'].'&server_os='.$data['server_os'];
                $telemetry = file_get_contents($telemetry);

                return '1: '.$telemetry;
            } catch (Exception $e) {
                return '0';
            }
        } else {
            return '0';
        }
    } else {
        return '0';
    }
}
