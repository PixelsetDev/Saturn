<?php
/*
 * Saturn Updater
 * 0.x.x -> 0.1.1
 * Copyright 2021 LMWN
 */

$items = scandir(__DIR__);

foreach ($items as $item) {
    if ($item != '.' && $item != '..' && $item != 'config.php' && $item != 'theme.php' && $item != 'storage' && $item != 'themes' && $item != 'update.php') {
        remove($item);
    }
}

function remove($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                    remove($dir. DIRECTORY_SEPARATOR .$object);
                else
                    unlink($dir. DIRECTORY_SEPARATOR .$object);
            }
        }
        rmdir($dir);
    }
}

$remoteVersion = file_get_contents('https://link.saturncms.net/?latest_version');

$downloadUrl = 'https://saturncms.net/download/update/'.$remoteVersion.'.zip';
$downloadTo = 'update.zip';

if (strpos($downloadUrl, 'saturncms.net') !== false) {
    $installFile = $downloadTo;
    file_put_contents($installFile, fopen($downloadUrl, 'r'));
    $path = pathinfo(realpath($installFile), PATHINFO_DIRNAME);
    $archive = new ZipArchive();
    $res = $archive->open($installFile);
    if ($res) {
        $archive->extractTo($path);
        $archive->close();
        if (!unlink($installFile)) {
            $complete = false;
            $errorMsg = 'Saturn update error: Unable to delete the system update.';
        } else {
            $complete = true;
        }
    } else {
        $complete = false;
        $errorMsg = 'Saturn update error: Unable to unzip the archive.';
    }
} else {
    $complete = false;
    $errorMsg = 'Saturn update error: Halted download from untrusted URL. Attempted to download from: '.$downloadUrl;
}

// done
unlink('update.php');

if ($complete) {
    echo '<h1>Saturn has been updated.</h1><br><a href="/panel/admin">Back to the Admin Panel</a>.';
    exit;
} else {
    echo '<h1>There was a problem whilst updating Saturn.</h1><br><a href="/panel/admin">Back to the Admin Panel</a>.<br><br>';
    echo $errorMsg;
}