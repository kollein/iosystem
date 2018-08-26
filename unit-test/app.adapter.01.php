<?php
echo '<br>';
echo '$_route_uri: ' . $_route_uri . '<br>';
echo '$_explicit_uri: ' . $_explicit_uri . '<br>';
echo '$_route_level_uri: ' . $_route_level_uri . '<br>';
echo '$_path_uri: ' . $_path_uri . '<br>';
echo '$_routes: |<br>';
print_r(Route::$_routes);
echo '<br>';
