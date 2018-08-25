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

    public static function post($path, $mixedCA, $privileges)
    {
        if (self::isValidPath($path) && self::isValidController($mixedCA)) {
            $route = [
                "METHOD" => 'POST',
                "PATH" => $path,
                "CONTROLLER" => $mixedCA,
                "PRIVILEGES" => $privileges,
            ];

            array_push(self::$_routes['POST'], $route);
        }

    }

    public static function get($path, $mixedCA, $privileges)
    {
        if (self::isValidPath($path) && self::isValidController($mixedCA)) {
            $route = [
                "METHOD" => 'GET',
                "PATH" => $path,
                "CONTROLLER" => $mixedCA,
                "PRIVILEGES" => $privileges,
            ];

            array_push(self::$_routes['GET'], $route);
        }

    }

    public static function isExistRoute($path, $method)
    {
        $result = false;

        foreach (self::$_routes[$method] as $route) {
            $result = $route['PATH'] === $path ? true : false;
            break;
        }

        return $result;
    }

    public static function getRoute($path, $method)
    {
        $result = false;

        foreach (self::$_routes[$method] as $route) {
            $result = $route['PATH'] === $path ? $route : false;
            break;
        }

        return $result;
    }

    public static function isValidPath($path)
    {
        return preg_match("|^[a-z0-9-/]+$|i", $path) ? true : false;
    }

    public static function isValidController($mixed)
    {
        return preg_match("|^[a-z]+@[a-z]+$|i", $mixed) ? true : false;
    }
}
