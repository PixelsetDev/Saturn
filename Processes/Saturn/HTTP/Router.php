<?php

/**
 * Saturn Response.php - Router.
 *
 * Modified version of the PHPRouter - MIT License (https://github.com/phprouter/main/blob/main/LICENSE)
 */

namespace Saturn\Saturn\HTTP;

class Router
{
    public function GET($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->route($route, $path_to_include);
        } else {
            $this->bad();
        }
    }

    public function POST($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->route($route, $path_to_include);
        }
    }

    public function PUT($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $this->route($route, $path_to_include);
        }
    }

    public function PATCH($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
            $this->route($route, $path_to_include);
        }
    }

    public function DELETE($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $this->route($route, $path_to_include);
        }
    }

    public function ANY($route, $path_to_include)
    {
        $this->route($route, $path_to_include);
    }

    public function route($route, $path_to_include)
    {
        $callback = $path_to_include;
        if (!is_callable($callback)) {
            if (!strpos($path_to_include, '.php')) {
                $path_to_include .= '.php';
            }
        }
        if ($route == '/404') {
            require_once __DIR__.'/'.$path_to_include;
            $Response = new Response();
            $Response->HTTP404();
            exit;
        }
        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $request_url = rtrim($request_url, '/');
        $request_url = strtok($request_url, '?');
        $route_parts = explode('/', $route);
        $request_url_parts = explode('/', $request_url);
        array_shift($route_parts);
        array_shift($request_url_parts);
        if ($route_parts[0] == '' && count($request_url_parts) == 0) {
            if (is_callable($callback)) {
                call_user_func_array($callback, []);
                exit;
            }
            require_once __DIR__.'/../../'.$path_to_include;
            exit;
        }
        if (count($route_parts) != count($request_url_parts)) {
            return;
        }
        $parameters = [];
        for ($__i__ = 0; $__i__ < count($route_parts); $__i__++) {
            $route_part = $route_parts[$__i__];
            if (preg_match('/^[$]/', $route_part)) {
                $route_part = ltrim($route_part, '$');
                array_push($parameters, $request_url_parts[$__i__]);
                $$route_part = $request_url_parts[$__i__];
            } elseif ($route_parts[$__i__] != $request_url_parts[$__i__]) {
                return;
            }
        }
        // Callback function
        if (is_callable($callback)) {
            call_user_func_array($callback, $parameters);
            exit;
        }
        require_once __DIR__.'/../../'.$path_to_include;
        exit;
    }

    public function http_bad()
    {
        $Response = new Response();
        $Response->HTTP405();
    }
}
