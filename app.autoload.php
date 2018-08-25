<?php
/*
 ** This is Application Module
 ** Running across the system
 */

// autoload function
function __autoload($class)
{
    $stack_class = explode('\\', strtolower($class));
    $store_name = $stack_class[0];
    print_r($stack_class);

    switch ($store_name) {
        case 'route':
            $ready_path = 'module/router.module.php';
            break;
        case 'adapter':
            $ready_path = 'module/adapter.module.php';
            break;
        case 'controller':
            $ready_path = 'controller/user/index.controller.php';
            break;

        default:
            $ready_path = $store_name . '/' . $stack_class[1] . '.' . $store_name . '.php';
            break;
    }

    echo 'Path: ' . $ready_path;

    require_once $ready_path;
}
