<?php
    /*
     * Saturn v1.0.0 Configuration File
     * Copyright (c) 2021 - Saturn Authors
     * saturncms.net
     *
     * It is recommended that you edit this in the administration panel unless you know what you're doing.
     * For help visit docs.saturncms.net
     */

    /* General */
    define('CONFIG_INSTALL_URL', '/Saturn_BETA');
    define('CONFIG_SITE_NAME', 'Saturn on LMWN Workshop');
    define('CONFIG_SITE_DESCRIPTION', 'A website running the Saturn Content Management System.');
    define('CONFIG_SITE_KEYWORDS', '');
    define('CONFIG_SITE_CHARSET', 'UTF-8');
    define('CONFIG_SITE_TIMEZONE', 'Europe/London');
    /* Database */
    define('DATABASE_HOST', 'localhost');
    define('DATABASE_PORT', '3306');
    define('DATABASE_NAME', '');
    define('DATABASE_USERNAME', '');
    define('DATABASE_PASSWORD', '');
    define('DATABASE_PREFIX', '');
    /* Email */
    define('CONFIG_EMAIL_ADMIN', '');
    define('CONFIG_EMAIL_FUNCTION', 'phpmail');
    define('CONFIG_EMAIL_SENDFROM', 'noreply@saturncms.net');
    /* Editing */
    define('CONFIG_PAGE_APPROVALS', true);
    define('CONFIG_MAX_TITLE_CHARS', '64');
    define('CONFIG_MAX_PAGE_CHARS', '50000');
    define('CONFIG_MAX_ARTICLE_CHARS', '50000');
    define('CONFIG_MAX_REFERENCES_CHARS', '10000');
    define('CONFIG_MAX_BLOCK_CHARS', '2000');
    /* Developer Tools */
    define('CONFIG_DEBUG', false);
    define('CONFIG_PHP_ERRORS', false);
    /* Global Security System */
    define('SECURITY_ACTIVE', true);
    define('SECURITY_MODE', 'clean');
    define('LOGGING_ACTIVE', true);
