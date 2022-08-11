<?php
/**
 * Saturn Settings file.
 *
 * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
 * @license     Apache 2.0
 *
 * @since       1.0.0
 *
 * @version     1.0.0
 */

// Website
const WEBSITE_NAME = 'Saturn';
const WEBSITE_DESCRIPTION = 'This website is powered by Saturn.';

// Panel
const PANEL_LANGUAGE = 'EN';
const PANEL_IMAGE_QUALITY = 'HD';

//  Database
const DATABASE_HOSTNAME = 'localhost';
const DATABASE_USERNAME = 'root';
const DATABASE_PASSWORD = '';
const DATABASE_DATABASE = 'saturn';
const DATABASE_PORT = null;
const DATABASE_PREFIX = 'saturn_';
const DATABASE_SOCKET = null;

// Security
const SECURITY_PASSWORD_HASH = PASSWORD_DEFAULT;
const SECURITY_IP_HASH = 'sha3-512';
const SECURITY_HASH_SALT = '828765';
const SECURITY_OTHER_HASH = 'sha3-512';

// JSON Web Tokens
const JWT_SECRET = '89uru897349u8erwitefjkn4r78';
const JWT_ISSUER = 'Boa';
const JWT_ALGORITHM = 'HS512';

// Email
const EMAIL_SENDFROM = 'noreply@example.com';

// Boa
const BOA_SHOW_WARNINGS = true;
const BOA_SHOW_ERRORS = true;
const BOA_SHOW_FATAL_ERRORS = true;
const BOA_UPDATE_CHECK = false;

// Debug
const DEBUG = true;
const DEBUG_INSECURE = true;

// API
const CUSTOM_API_LOCATION = false;
