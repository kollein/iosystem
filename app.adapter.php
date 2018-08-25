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

// echo $path . '<br>';
// echo $_SERVER['REQUEST_METHOD'] . '<br>';

// print_r(Route::$_routes);

// $isExistRoute = Route::isExistRoute($path, $_SERVER['REQUEST_METHOD']);

// var_dump($isExistRoute);

$route = Route::getRoute($path, $_SERVER['REQUEST_METHOD']);

if ($route) {

    $controller_name = Adapter::getController($route['CONTROLLER']);
    $controller_namespace = 'Controller\\' . $_route_uri . '\\';
    $class_name = $controller_namespace . $controller_name . 'Controller';
    echo '<br>' . $controller_namespace . '<br>';
    $operator = new $class_name();
    echo $operator->_name;

} else {

    echo 'Route is not defined';

}
