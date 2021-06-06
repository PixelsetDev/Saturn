<?php
    if (CONFIG_DEBUG == true) {log_console('Saturn][Resource Loader', 'Resource loader started.');}
    require_once 'global_tags.php';
    require_once 'plugins.php';
    require_once 'themes.php';
    if (CONFIG_DEBUG == true) {log_console('Saturn][Resource Loader', 'Resource loader stopped.');}