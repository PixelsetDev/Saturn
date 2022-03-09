<?php

    function latest_version()
    {
        $remoteVersion = file_get_contents('https://link.saturncms.net/?latest_version='.SATURN_BRANCH);
        if (($remoteVersion != SATURN_VERSION) && $remoteVersion != null) {
            return $remoteVersion;
        } else {
            return SATURN_VERSION;
        }
    }
