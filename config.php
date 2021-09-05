<?php

    /*
     * Saturn Configuration File
     * Copyright (c) 2021 - Saturn Authors
     * saturncms.net
     *
     * You should not edit this file directly as it can cause errors to occur.
     * Please visit the Admin Panel's Website Settings page to change this file from there.
     *
     * For help visit docs.saturncms.net
     */

    /* General */
    const CONFIG_INSTALL_URL = '';
    const CONFIG_ACTIVATION_KEY = '';
    const CONFIG_SITE_NAME = 'Saturn';
    const CONFIG_SITE_DESCRIPTION = 'A website running the Saturn Content Management System.';
    const CONFIG_SITE_KEYWORDS = 'saturn, cms, website';
    const CONFIG_SITE_CHARSET = 'UTF-8';
    const CONFIG_SITE_TIMEZONE = 'Europe/London';
    /* Database */
    const DATABASE_HOST = 'localhost';
    const DATABASE_NAME = '';
    const DATABASE_USERNAME = '';
    const DATABASE_PASSWORD = '';
    const DATABASE_PORT = '3306';
    const DATABASE_PREFIX = 'sat_';
    /* Email */
    const CONFIG_EMAIL_ADMIN = '';
    const CONFIG_EMAIL_FUNCTION = 'phpmail';
    const CONFIG_EMAIL_SENDFROM = 'noreply@saturncms.net';
    /* Editing */
    const CONFIG_PAGE_APPROVALS = true;
    const CONFIG_ARTICLE_APPROVALS = true;
    const CONFIG_MAX_TITLE_CHARS = '64';
    const CONFIG_MAX_PAGE_CHARS = '50000';
    const CONFIG_MAX_ARTICLE_CHARS = '50000';
    const CONFIG_MAX_REFERENCES_CHARS = '10000';
    /* Notifications */
    const CONFIG_NOTIFICATIONS_LIMIT = '50';
    const CONFIG_ALLOW_SATURN_NOTIFICATIONS = true;
    const CONFIG_ALLOW_EMAIL_NOTIFICATIONS = true;
    /* Welcome Screen */
    const CONFIG_WELCOME_SCREEN = true;
    const CONFIG_WELCOME_SCREEN_SHOW_TERMS = true;
    /* Security */
    const SECURITY_ACTIVE = true;
    const SECURITY_MODE = 'clean';
    const LOGGING_ACTIVE = true;
    const LOGGING_AUTOLOG = false;
    /* Developer Tools */
    const CONFIG_DEBUG = false;
    /* Permissions */
    const PERMISSION_CREATE_CATEGORY = '4';
    const PERMISSION_CREATE_PAGE = '4';
    const PERMISSION_EDIT_PAGE_SETTINGS = '3';