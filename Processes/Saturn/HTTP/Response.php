<?php

/**
 * Saturn HTTP - Response.
 *
 * Sends HTTP headers with response codes.
 */

namespace Saturn\HTTP;

class Response
{

    public function HTTP403(): void
    {
        header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden', true, 403);
        exit;
    }

    public function HTTP404(): void
    {
        header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
        exit;
    }

    public function HTTP405(): void
    {
        header($_SERVER['SERVER_PROTOCOL'].' 405 Method Not Allowed', true, 405);
        exit;
    }

    public function HTTP500()
    {
        header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error', true, 500);
        exit;
    }
}
