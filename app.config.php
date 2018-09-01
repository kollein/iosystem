<?php

// error_reporting(0);
date_default_timezone_set('UTC');

const CONNECTION_INFO = ['mysql:host=localhost;dbname=iosystem', 'root', '12345678'];

/* FULL CURRENT URL */
// Get HTTP/HTTPS (the possible values for this vary from server to server)
$myUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']), array('off', 'no'))) ? 'https' : 'http';
// Get domain portion
$myUrl .= '://' . $_SERVER['HTTP_HOST'];
// Get path to script
$myUrl .= $_SERVER['REQUEST_URI'];
// Add path info, if any
if (!empty($_SERVER['PATH_INFO'])) {
    $myUrl .= $_SERVER['PATH_INFO'];
}

/* END FULL CURRENT URL */

/* ENVIROMENT FOR GET DATA */
define(CLIENT_IP, $_SERVER['REMOTE_ADDR']);
/* IS MOBILE */
define(IS_MOBILE, preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]));

// General Constant
const URLBASE = '//www.iosystem.com';

// TABLE
const USER = 'USER';

// COOKIE USER LOG
define(USER_COOKIE, $_COOKIE['u']);

// TIME DATE
define(_TIMESTAMP, date('Y-m-d H:i'));
// ROOT_DIR :
define('ROOT_DIR', dirname(__FILE__));
// UPLOAD DESTINATION
const PATH_URI_PX_UPLOAD_DES = URLBASE;
const IMG_CDN = '/img/cdn1';
const IMG_CDN_REAL_PHOTO = '/img/cdn-rp';
const IMG_CDN_EDITOR = '/img/cdn1_Editor';
