<?php

function marketplace_download_zip($download_url, $download_to, $delete_zip = true): bool
{
    $download_url = checkInput('DEFAULT', $download_url);
    $download_to = checkInput('DEFAULT', $download_to);
    if (!is_bool($delete_zip)) { $delete_zip = checkInput('DEFAULT', $delete_zip); }
    if (strpos($download_url, 'marketplace.saturncms.net') !== false) {

        $file = __DIR__ . $download_to;
        $script = basename($_SERVER['PHP_SELF']);

        // Download file
        file_put_contents($file, fopen($download_url, 'r'));

        // Extract
        $path = pathinfo(realpath($file), PATHINFO_DIRNAME);

        $zip = new ZipArchive();
        $res = $zip->open($file);

        if ($res) {
            $zip->extractTo($path);
            $zip->close();
            if ($delete_zip) {
                if (!unlink($file)) {
                    $complete = false;
                } else {
                    $complete = true;
                }
            } else {
                $complete = true;
            }
        } else {
            $complete = false;
        }
    } else {
        $complete = false;
    }

    return $complete;
}