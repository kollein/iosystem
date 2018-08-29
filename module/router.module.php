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
    public static $_request_method = false;
    public static $_path_uri = false;
    public static $_route = [
        "METHOD" => false,
        "PATH" => false,
        "CONTROLLER" => false,
        "MIDDLEWARE" => false,
    ];
    /*
     ** LEVEL-OVERHEAD is defined to reduce operation
     ** It depends on checking of incoming request in every defined-route
     ** Status:
     ** 0 : Percentage of loss [0%]
     ** 7 : Percentage of loss [70%]
     ** 1 : Percentage of loss [10%]
     */
    public static $_summary_overhead = [];
    public static $_current_overhead_status = 0;

    public static function post($path, $controller_node_syntax = DEFAULT_C_NODE_SYNTAX, $middleware_node_syntax = false)
    {
        self::$_method = strtoupper(__FUNCTION__);
        self::prepareRoute($path, $controller_node_syntax, $middleware_node_syntax);
        return new self;
    }

    public static function get($path, $controller_node_syntax = DEFAULT_C_NODE_SYNTAX, $middleware_node_syntax = false)
    {
        self::$_method = strtoupper(__FUNCTION__);
        self::prepareRoute($path, $controller_node_syntax, $middleware_node_syntax);
        return new self;
    }

    protected function addOverhead($status)
    {
        if ($status > 0) {

            self::$_current_overhead_status = $status;
            array_push(self::$_summary_overhead, $status);
            // RESET AFTER CACHE
            self::$_path = false;
        } else {

            self::$_current_overhead_status = false;
        }
    }

    protected function prepareRoute($path, $controller_node_syntax, $middleware_node_syntax)
    {
        echo '<br>Route Method : ' . self::$_method . '<br>';

        // Reduce Overhead
        if (self::$_method !== self::$_request_method) {
            echo '<br> Stop at method checking : ' . $path . ' <br>';
            self::addOverhead(1);

        } else {

            $path = strtolower($path);

            // cache
            self::$_path = $path;
            self::$_controller_node_syntax = self::isControllerNodeSyntax($controller_node_syntax) ? $controller_node_syntax : self::DEFAULT_C_NODE_SYNTAX;
            self::$_middleware_node_syntax = self::isMiddlewareNodeSyntax($middleware_node_syntax) ? $middleware_node_syntax : false;

            if (gettype($controller_node_syntax) === 'object') {

                /*
                 ** $controller_node_syntax is callback now and return data, so it has two-way binding mechanism
                 ** Data is null (not return) or an array (return) which to be defined:
                 ** [0]: string : 'controller@action'
                 ** [1]: string : 'middleware@action'
                 */
                self::cacheCallbackData($controller_node_syntax());

            } else {

                self::setRoute();
            }

        }
    }

    protected function setRoute()
    {

        if (self::isValidPath(self::$_path) &&
            self::isControllerNodeSyntax(self::$_controller_node_syntax)
        ) {

            $path = trimForwardSlash(self::$_path);
            $ready_path = self::$_prefix ? self::$_prefix . '/' . $path : $path;

            // Reduce Overhead
            $path_pattern = '|' . $ready_path . '|i';

            if (!preg_match($path_pattern, self::$_path_uri)) {
                echo '<br> Stop Definately In Set Route Function : ' . $ready_path . ' <br>';
                self::addOverhead(7);
                return;
            }

            self::$_route = [
                "METHOD" => self::$_method,
                "PATH" => $ready_path,
                "CONTROLLER" => self::$_controller_node_syntax,
                "MIDDLEWARE" => self::$_middleware_node_syntax,
            ];

        }

    }

    public static function cacheRequestURL($path_uri, $method)
    {
        self::$_request_method = $method;
        self::$_path_uri = $path_uri;
    }

    public static function getRoute($path_uri)
    {
        // Cache $path_uri
        self::$_path_uri = $path_uri;

        $result = false;

        foreach (self::$_routes[self::$_request_method] as $route) {

            $path_pattern = '|^' . $route['PATH'] . '$|i';

            if (preg_match($path_pattern, self::$_path_uri)) {
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

        if (self::$_current_overhead_status > 0) {
            echo 'Stop Definately In Where Condition <br>';
            self::addOverhead(0);
            return;
        }

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
