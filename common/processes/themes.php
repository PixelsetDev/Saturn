<?php

    function list_page_templates(): string
    {
        // This will be changed soon but it's staying here because it can.
        return 'DEFAULT';
    }

    function get_remote_marketplace_version($slug, $type): string
    {
        return file_get_contents('https://link.saturncms.net/marketplace/?version_check=theme&slug='.$slug.'&type='.$type);
    }