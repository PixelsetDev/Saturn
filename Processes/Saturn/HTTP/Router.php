<?php

/**
 * Saturn Response.php - Router.
 *
 * Modified version of the PHPRouter - MIT License (https://github.com/phprouter/main/blob/main/LICENSE)
 */

namespace Saturn\HTTP;

class Router
{
    public function GET($Route, $IncludePath): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->route($Route, $IncludePath);
        } else {
            $this->BadRequest();
        }
    }

    public function POST($Route, $IncludePath): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->route($Route, $IncludePath);
        }
    }

    public function PUT($Route, $IncludePath): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $this->route($Route, $IncludePath);
        }
    }

    public function PATCH($Route, $IncludePath): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
            $this->route($Route, $IncludePath);
        }
    }

    public function DELETE($Route, $IncludePath): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $this->route($Route, $IncludePath);
        }
    }

    public function ANY($Route, $IncludePath): void
    {
        $this->route($Route, $IncludePath);
    }

    public function route($Route, $IncludePath): void
    {
        if (!is_callable($IncludePath) && !strpos($IncludePath, '.php')) {
            $IncludePath .= '.php';
        }
        if ($Route == '/404') {
            require_once __DIR__.'/'.$IncludePath;
            $Response = new Response();
            $Response->HTTP404();
            exit;
        }
        $RequestURL = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $RequestURL = rtrim($RequestURL, '/');
        $RequestURL = strtok($RequestURL, '?');
        $RouteParts = explode('/', $Route);
        $RequestURLParts = explode('/', $RequestURL);
        array_shift($RouteParts);
        array_shift($RequestURLParts);
        if ($RouteParts[0] == '' && count($RequestURLParts) == 0) {
            if (is_callable($IncludePath)) {
                call_user_func_array($IncludePath, []);
                exit;
            }
            require_once __DIR__.'/../../'.$IncludePath;
            exit;
        }
        if (count($RouteParts) !== count($RequestURLParts)) {
            return;
        }
        $Parameters = [];
        for ($Part = 0; $Part < count($RouteParts); $Part++) {
            $RoutePart = $RouteParts[$Part];
            if (preg_match('/^[$]/', $RoutePart)) {
                $RoutePart = ltrim($RoutePart, '$');
                $Parameters[] = $RequestURLParts[$Part];
                $$RoutePart = $RequestURLParts[$Part];
            } elseif ($RouteParts[$Part] != $RequestURLParts[$Part]) {
                return;
            }
        }
        // Callback function
        if (is_callable($IncludePath)) {
            call_user_func_array($IncludePath, $Parameters);
            exit;
        }
        require_once __DIR__.'/../../'.$IncludePath;
        exit;
    }

    public function BadRequest(): void
    {
        $Response = new Response();
        $Response->HTTP405();
    }
}
