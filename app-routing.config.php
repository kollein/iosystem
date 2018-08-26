<?php
/*
 ** Router
 ** :: Method                  [POST, GET, PUT, DELETE]
 ** :: Path                    'abc'
 ** :: Controller - Action     'index@index'
 ** :: MiddleWare - Action     'user@checkLogin'
 */

Route::get('user/info', 'human@index1', 'user@checkLogin');
Route::get('user/info1', 'human@index1');
Route::post('user', 'index@index', 'user@checkPower');
