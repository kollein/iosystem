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
            /*
             ** $stack_class[1] : is context
             ** $stack_class[2] : is controller-name and is also (class-name)
             ** File Name Set-Rule  :
             ** ex: class IndexController {}
             ** That file-name must be (index.controller.php)
             */
            $ready_path = $store_name . '/' . $stack_class[1] . '/' . preg_replace('|controller$|', '', $stack_class[2]) . '.controller.php';
            break;
        case 'middleware':
            /*
             ** $stack_class[1] : is middleware-name and is also (class-name)
             */
            $ready_path = $store_name . '/' . preg_replace('|middleware$|', '', $stack_class[1]) . '.middleware.php';
            break;

        default:
            $ready_path = '404.php';
            break;
    }

    include './unit-test/app.autoload.02.php';

    require_once $ready_path;
}
