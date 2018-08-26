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

    include './unit-test/app.autoload.01.php';

    switch ($store_name) {
        case 'route':
            $ready_path = 'module/router.module.php';
            break;
        case 'adapter':
            $ready_path = 'module/adapter.module.php';
            break;
        case 'controller':
            $ready_path = $store_name . '/' . $stack_class[1] . '/' . str_replace('controller', '.controller', $stack_class[2]) . '.php';
            break;
        case 'middleware':
            $ready_path = $store_name . '/' . $stack_class[1] . '.middleware.php';
            break;

        default:
            $ready_path = '404.php';
            break;
    }

    include './unit-test/app.autoload.02.php';

    require_once $ready_path;
}
