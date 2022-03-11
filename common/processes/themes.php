<?php

    function get_remote_marketplace_version($slug, $type): string
    {
        return file_get_contents('https://link.saturncms.net/marketplace/?version_check='.$type.'&slug='.$slug);
    }