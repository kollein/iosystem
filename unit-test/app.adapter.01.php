<?php
if (UNIT_TEST_MODE) {
    echo '<br><div class="start-line">' . basename(__FILE__) . '</div>';
    echo 'METHOD: ' . $_SERVER['REQUEST_METHOD'] . '<br>';
    echo '$_route_uri: ' . $_route_uri . '<br>';
    echo '$_explicit_uri: ' . $_explicit_uri . '<br>';
    echo '$_route_level_uri: ' . $_route_level_uri . '<br>';
    echo '$_path_uri: ' . $_path_uri . '<br>';
    echo '<br>';
}
