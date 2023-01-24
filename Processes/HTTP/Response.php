<?php

/**
 * Saturn HTTP - Response
 *
 * Sends HTTP headers with response codes.
 */

namespace Saturn\HTTP;

class Response {
    public function HTTP404(): void
    {
        header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found", true, 404);
        exit;
    }

    public function HTTP405(): void
    {
        header($_SERVER['SERVER_PROTOCOL'] . " 405 Method Not Allowed", true, 405);
        exit;
    }
}