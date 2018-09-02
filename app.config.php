<?php
/*
 ** Application Configuration
 ** Database, Table, System, Miscellaneous
 */

// error_reporting(0);
date_default_timezone_set('UTC');

/* ENVIROMENT FOR GET DATA */
const CONNECTION_INFO = ['mysql:host=localhost;dbname=iosystem', 'root', '12345678'];
const SESSION_TIMEZONE = "SET SESSION time_zone = '+7:00'";

define(CLIENT_IP, $_SERVER['REMOTE_ADDR']);
define(IS_MOBILE, preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]));
// URL
const URLBASE = '//www.iosystem.com';

// TABLE
const USER = 'USER';

// COOKIE
define(USER_COOKIE, $_COOKIE['u']);

// DATE TIME
define(_TIMESTAMP, date('Y-m-d H:i'));
// ROOT FOLDER
define('ROOT_DIR', dirname(__FILE__));
// UPLOAD DESTINATION FOLDER
const PATH_URI_PX_UPLOAD_DES = URLBASE;
const IMG_CDN = '/img/cdn1';
const IMG_CDN_REAL_PHOTO = '/img/cdn-rp';
const IMG_CDN_EDITOR = '/img/cdn1_Editor';

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

// DEVELOPER ENVIROMENT
const UNIT_TEST_MODE = true;
include './unit-test/app.php';
