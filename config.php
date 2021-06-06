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
    const CONFIG_INSTALL_URL = '/Saturn_BETA';
    const CONFIG_SITE_NAME = 'Saturn on LMWN Workshop';
    const CONFIG_SITE_DESCRIPTION = 'A website running the Saturn Content Management System.';
    const CONFIG_SITE_KEYWORDS = '';
    const CONFIG_SITE_CHARSET = 'UTF-8';
    const CONFIG_SITE_TIMEZONE = 'Europe/London';
    /* Database */
    const DATABASE_HOST = 'localhost';
    const DATABASE_PORT = '3306';
    const DATABASE_NAME = '';
    const DATABASE_USERNAME = '';
    const DATABASE_PASSWORD = '';
    const DATABASE_PREFIX = 'sat_';
    /* Email */
    const CONFIG_EMAIL_ADMIN = '';
    const CONFIG_EMAIL_FUNCTION = 'phpmail';
    const CONFIG_EMAIL_SENDFROM = 'noreply@saturncms.net';
    /* Editing */
    const CONFIG_PAGE_APPROVALS = true;
    const CONFIG_MAX_TITLE_CHARS = '64';
    const CONFIG_MAX_PAGE_CHARS = '50000';
    const CONFIG_MAX_ARTICLE_CHARS = '50000';
    const CONFIG_MAX_REFERENCES_CHARS = '10000';
    const CONFIG_MAX_BLOCK_CHARS = 2000;
    /* Developer Tools */
    const CONFIG_DEBUG = false;
    const CONFIG_PHP_ERRORS = false;
    /* Global Security System */
    const SECURITY_ACTIVE = true;
    const SECURITY_MODE = 'clean';
    const LOGGING_ACTIVE = true;