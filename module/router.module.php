<?php

/*
 ** Glossary:
 ** 1. Node Syntax: is combination between class and method name
 ** and to be separated by @ sign
 ** ex: indexcontroller@index
 */

class Route
{
    const DEFAULT_C_NODE_SYNTAX = 'indexcontroller@index';
    const C_NODE_SYNTAX_PATTERN = '|^[a-z]+[0-9]*controller@[a-z]+[0-9]*$|i';
    const M_NODE_SYNTAX_PATTERN = '|^[a-z]+[0-9]*middleware@[a-z]+[0-9]*$|i';

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
        self::$_method = strtoupper(__FUNCTION__);
        self::prepareRoute($path, $controller_node_syntax, $middleware_node_syntax);

        if (gettype($controller_node_syntax) === 'object') {

            /*
             ** $controller_node_syntax is callback now and return data, so it has two-way binding mechanism
             ** Data is null (not return) or an array (return) which to be defined:
             ** [0]: string : 'controller@action'
             ** [1]: string : 'middleware@action'
             */
            self::cacheCallbackData($controller_node_syntax());

            return new self;

        } else {
            echo 'not object';
            self::setRoute();

        }
    }

    protected function prepareRoute($path, $controller_node_syntax, $middleware_node_syntax)
    {
        $path = strtolower($path);

        // cache
        self::$_path = $path;
        self::$_controller_node_syntax = self::isControllerNodeSyntax($controller_node_syntax) ? $controller_node_syntax : self::DEFAULT_C_NODE_SYNTAX;
        self::$_middleware_node_syntax = self::isMiddlewareNodeSyntax($middleware_node_syntax) ? $middleware_node_syntax : false;
    }

    protected function setRoute()
    {
        echo '<br><br><br>VINHNRE' . self::$_controller_node_syntax . '<br><br><br>';

        if (self::isValidPath(self::$_path) &&
            self::isControllerNodeSyntax(self::$_controller_node_syntax)
        ) {

            $path = trimForwardSlash(self::$_path);
            $ready_path = self::$_prefix ? self::$_prefix . '/' . $path : $path;

            $route = [
                "METHOD" => self::$_method,
                "PATH" => $ready_path,
                "CONTROLLER" => self::$_controller_node_syntax,
                "MIDDLEWARE" => self::$_middleware_node_syntax,
            ];

            array_push(self::$_routes[self::$_method], $route);
        }

    }

    public static function getRoute($path_uri, $method)
    {
        // Cache $path_uri
        self::$_path_uri = $path_uri;

        $result = false;

        foreach (self::$_routes[$method] as $route) {

            if ($route['PATH'] === self::$_path_uri) {
                $result = $route;
                break;
            }

        }

        return $result;
    }

    protected function isValidPath($path)
    {
        return preg_match("|^[^'\"]+$|i", $path);
    }

    protected function isControllerNodeSyntax($mixed)
    {
        return gettype($mixed) !== 'string' ? false : preg_match(self::C_NODE_SYNTAX_PATTERN, $mixed);
    }

    protected function isMiddlewareNodeSyntax($mixed)
    {
        return gettype($mixed) !== 'string' ? false : preg_match(self::M_NODE_SYNTAX_PATTERN, $mixed);
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
        // $_path: has been merged with condition
        self::$_path = join('/', self::mergeCondition($condition));

        echo self::$_method . '<br>';
        echo self::$_path . '<br>';
        echo self::$_controller_node_syntax . '<br>';
        echo self::$_middleware_node_syntax . '<br>';

        self::setRoute();

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

    protected function cacheCallbackData($data)
    {

        if ($data !== null) {

            self::$_controller_node_syntax = self::isControllerNodeSyntax($data['controller']) ? $data['controller'] : self::DEFAULT_C_NODE_SYNTAX;

            self::$_middleware_node_syntax = self::isMiddlewareNodeSyntax($data['middleware']) ? $data['middleware'] : false;
        }
    }

}
