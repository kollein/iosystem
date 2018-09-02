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
        Route::get('info', 'HumanController@index1');
        Route::get('info3', 'HumanController@index1');
        Route::get('{id}', function () {

            return [
                'controller' => 'humancontroller@index1',
                'middleware' => 'AdminMiddleware@checkPower1',
            ];

        })->where(['id' => '[0-9]+']);
    });
});

Route::prefix('user')->group(function () {

    Route::post('{name}', function () {

        return [
            'controller' => 'humancontroller@index1',
            'middleware' => 'usermiddleware@checkLogin',
        ];

    })->where(['name' => '[a-z]+']);

});

include './unit-test/app-routing.config.01.php';
