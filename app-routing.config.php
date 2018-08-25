<?php
/*
 ** Router
 ** :: Method [POST, GET, PUT, DELETE]
 ** :: Path 'abc'
 ** :: Controller - Action 'index@index'
 ** :: Privileges Level [admin, member, guest]
 */

Route::get('user/info', 'index@index', 'member');
Route::post('getcoin', 'index@index', 'admin');
