<?php

class Route
{

    public static $_routes = [
        "POST" => [],
        "GET" => [],
        "PUT" => [],
        "DELETE" => [],
    ];

    public function __construct()
    {

    }

    public static function post($path, $mixedCA, $middleware = false)
    {
        self::setRoute($path, $mixedCA, $middleware, 'POST');
    }

    public static function get($path, $mixedCA, $middleware = false)
    {
        self::setRoute($path, $mixedCA, $middleware, 'GET');
    }

    protected static function setRoute($path, $mixedCA, $middleware, $method)
    {
        if (self::isValidPath($path) && self::isValidController($mixedCA)) {
            $route = [
                "METHOD" => $method,
                "PATH" => $path,
                "CONTROLLER" => $mixedCA,
                "MIDDLEWARE" => $middleware,
            ];

            array_push(self::$_routes[$method], $route);
        }

    }

    public static function getRoute($path, $method)
    {
        $result = false;

        foreach (self::$_routes[$method] as $route) {

            if ($route['PATH'] === $path) {
                $result = $route;
                break;
            }

        }

        return $result;
    }

    public static function isValidPath($path)
    {
        return preg_match("|^[a-z0-9-/]+$|i", $path) ? true : false;
    }

    public static function isValidController($mixed)
    {
        return preg_match("|^[a-z]+@[a-z0-9]+$|i", $mixed) ? true : false;
    }
}
