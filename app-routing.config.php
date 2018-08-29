<?php
/*
 ** Router
 ** :: Method                  [POST, GET, PUT, DELETE]
 ** :: Path                    'abc'
 ** :: Controller - Action     'index@index'
 ** :: MiddleWare - Action     'user@checkLogin'
 */

Route::prefix('user')->group(function () {
    Route::get('info', 'humancontroller@index1', 'usermiddleware@checkLogin');
    // Route::post('kollein/id', 'human@index1');
});

// Route::get('user/info', 'humancontroller@index1', 'usermiddleware@checkLogin');

// Route::post('agent/{name}', function () {

//     return ['controller' => 'humancontroller@index1',
//         'middleware' => 'usermiddleware@checkLogin'];

// })->where(['name' => '[a-z]+']);

// Route::get('user/{id}', function () {

//     return ['controller' => 'humancontroller@index1',
//         'middleware' => 'usermiddleware@checkLogin'];

// })->where(['id' => '[0-9]+']);

include './unit-test/app-routing.config.01.php';
