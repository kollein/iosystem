<?php

/*
 ** Glossary:
 ** 1. Node Syntax: is combination between class and method of its
 ** and to be separated by @ sign
 ** ex: indexcontroller@index
 */

class Route
{
    const DEFAULT_C_NODE_SYNTAX = 'indexcontroller@index';

    // When a route is initialized
    public static $_prefix = false;
    public static $_method = false;
    public static $_path = false;
    public static $_controller_node_syntax = false;
    public static $_middleware_node_syntax = false;

    // When a request is called
    public static $_path_uri = false;

    public static $_routes = [
        "POST" => [],
        "GET" => [],
        "PUT" => [],
        "DELETE" => [],
    ];

    public function __construct()
    {

    }

    public static function post($path, $controller_node_syntax, $middleware_node_syntax = false)
    {
        $path = strtolower($path);
        self::setRoute($path, $controller_node_syntax, $middleware_node_syntax, 'POST');
    }

    public static function get($path, $controller_node_syntax = DEFAULT_C_NODE_SYNTAX, $middleware_node_syntax = false)
    {
        $path = strtolower($path);

        if (gettype($controller_node_syntax) === 'object') {

            /*
             ** $controller_node_syntax is callback now and return data, so it has two-way binding mechanism
             ** Data is null (not return) or an array which to be defined:
             ** [0]: string : 'controller@action'
             ** [1]: string : 'middleware@action'
             */
            self::cacheCallbackData($controller_node_syntax());

            // cache $path
            self::$_path = $path;
            self::$_method = strtoupper(__FUNCTION__);

            return new self;

        } else {

            self::setRoute($path, $controller_node_syntax, $middleware_node_syntax, 'GET');

        }
    }

    protected static function setRoute($path, $controller_node_syntax, $middleware_node_syntax, $method)
    {
        echo '<br><br><br>VINHNRE' . $controller_node_syntax . '<br><br><br>';
        if (self::isValidPath($path) && self::isValidController($controller_node_syntax)) {

            $path = trimForwardSlash($path);
            $ready_path = self::$_prefix ? self::$_prefix . '/' . $path : $path;

            $route = [
                "METHOD" => $method,
                "PATH" => $ready_path,
                "CONTROLLER" => $controller_node_syntax,
                "MIDDLEWARE" => $middleware_node_syntax,
            ];

            array_push(self::$_routes[$method], $route);
        }

    }

    public static function getRoute($path_uri, $method)
    {
        // Cache $path_uri
        self::$_path_uri = $path_uri;

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
        return preg_match("|^[^'\"]+$|i", $path) ? true : false;
    }

    public static function isValidController($mixed)
    {
        return preg_match("|^[a-z]+@[a-z0-9]+$|i", $mixed) ? true : false;
    }

    public static function prefix($path)
    {
        self::$_prefix = trimForwardSlash($path);
        return new self;
    }

    public function group($callback)
    {
        $callback();
        // RESET
        self::$_prefix = false;
    }

    public function where($condition)
    {
        $merged_path = join('/', self::mergeCondition($condition));

        echo self::$_method . '<br>';
        echo self::$_path . '<br>';
        echo $merged_path . '<br>';
        echo self::$_controller_node_syntax . '<br>';
        echo self::$_middleware_node_syntax . '<br>';

        self::setRoute($merged_path, self::$_controller_node_syntax, self::$_middleware_node_syntax, self::$_method);

    }

    protected function mergeCondition($condition)
    {
        $result = [];
        $stack_path = explode('/', self::$_path);

        foreach ($stack_path as $val) {

            if (preg_match('|{[a-z]+}|', $val)) {

                $key = preg_replace('/{|}/', '', $val);

                array_push($result, $condition[$key]);

            } else {

                array_push($result, $val);

            }

        }

        return $result;
    }

    public function isNodeSyntax($mixed)
    {

        return preg_match("|^[a-z]+@[a-z0-9]+$|i", $mixed) ? true : false;

    }

    protected function cacheCallbackData($data)
    {

        if ($data !== null) {

            self::$_controller_node_syntax = self::isNodeSyntax($data['controller']) ? $data['controller'] : DEFAULT_C_NODE_SYNTAX;

            self::$_middleware_node_syntax = self::isNodeSyntax($data['controller']) ? $data['middleware'] : false;
        }
    }

}
