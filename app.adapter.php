<?php
/*
 ** Adapter Mission is detect incoming route
 ** Then call appropriate Controller
 */

include 'app-routing.config.php';

$_route_uri = $_GET['route'];
$_explicit_uri = $_GET['explicit'];
$_route_level_uri = $_GET['route_level'];
$path = $_route_uri . ($_explicit_uri ? '/' . $_explicit_uri : '');

include './unit-test/app.adapter.01.php';

$route = Route::getRoute($path, $_SERVER['REQUEST_METHOD']);

if ($route) {
    /*
     ** Class is Case-Insensitive which has been affected by namespace
     ** In namespace of Classname Variable where the classname is part at the after last backslash
     */
    $authorized['code'] = 0;
    $authorized['message'] = 'Undefined';

    if (!$route['MIDDLEWARE']) {

        $authorized['code'] = 1;
        $authorized['message'] = 'No Integrated-MiddleWare';

    } else {

        // Invoke MiddleWare Task
        $middleware_name = Adapter::getAddressFirst($route['MIDDLEWARE']);
        $middleware_action_name = Adapter::getAddressLast($route['MIDDLEWARE']);
        $middleware_namespace = 'middleware\\' . $middleware_name;
        $middleware_class_name = $middleware_namespace . '\\' . $middleware_name;

        $_MIDDLEWARE_OPERATOR_ = new $middleware_class_name();
        $authorized = $_MIDDLEWARE_OPERATOR_->$middleware_action_name();

        include './unit-test/app.adapter.03.php';
    }

    // Check Authorization Result
    if ($authorized['code'] === 1) {

        $controller_name = Adapter::getAddressFirst($route['CONTROLLER']);
        $controller_action_name = Adapter::getAddressLast($route['CONTROLLER']);
        $controller_namespace = 'controller\\' . $_route_uri;
        $controller_class_name = $controller_namespace . '\\' . $controller_name . 'controller';

        $_OPERATOR_ = new $controller_class_name();
        echo $_OPERATOR_->$controller_action_name();

        include './unit-test/app.adapter.02.php';

        echo $authorized['message'];

    } else {

        echo $authorized['message'];

    }

} else {

    echo 'Route is not defined';

}
