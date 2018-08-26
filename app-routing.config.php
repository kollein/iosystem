<?php
/*
 ** Router
 ** :: Method                  [POST, GET, PUT, DELETE]
 ** :: Path                    'abc'
 ** :: Controller - Action     'index@index'
 ** :: MiddleWare - Action     'user@checkLogin'
 */

Route::prefix('user')->group(function () {
    // Route::get('info2', 'human@index1');
    // Route::post('kollein/id', 'human@index1');
});

// Route::get('user/info', 'human@index1', 'user@checkLogin');

Route::get('user/{id}', function () {

    return ['controller' => 'human@index1', 'middleware' => 'user@checkLogin'];

})->where(['id' => '[0-9]+']);

// Route::post('user', 'index@index', 'user@checkPower');
