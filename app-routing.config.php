<?php
/*
 ** Router
 ** :: Method                  [POST, GET, PUT, DELETE]
 ** :: Path                    'abc'
 ** :: Controller - Action     'IndexController@index'
 ** :: MiddleWare - Action     'UserMiddleware@checkLogin'
 */

Route::middleware('UserMiddleware@checkLogin')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('info', 'IndexController@index', 'AdminMiddleware@checkPower1');
        Route::get('info1', 'HumanController@index1');
        Route::get('info3', 'HumanController@index1');
    });
});

Route::prefix('user')->group(function () {
    Route::post('coin', 'humancontroller@index1', 'usermiddleware@checkLogin');
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
