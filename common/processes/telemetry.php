<?php
function send_data(): string
{
    if (CONFIG_SEND_STATS) {
        $data = array(
            'key' => urlencode(CONFIG_ACTIVATION_KEY),
            'saturn_version' => urlencode(SATURN_VERSION),
            'php_version' => urlencode(PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '.' . PHP_RELEASE_VERSION)
        );
        $telemetry = 'https://link.saturncms.net/telemetry/?key=' . $data['key'] . '&saturn_version=' . $data['saturn_version'] . '&php_version=' . $data['php_version'];
        return file_get_contents($telemetry);
    } else {
        return '0';
    }
}