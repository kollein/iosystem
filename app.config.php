<?php

// error_reporting(0);
date_default_timezone_set('UTC');
$conn = new PDO('mysql:host=localhost;dbname=iosystem', 'root', '12345678');

// error_reporting(0);
// date_default_timezone_set("Asia/Bangkok");
// $conn = new PDO('mysql:host=localhost;dbname=iosystem','phanminhhau','923757');

//VERY IMPORTANT TO QUERY AND SHOW TIME
$conn->exec("set names utf8");
$conn->query("SET SESSION time_zone = '+7:00'");

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
const CATES = 'CATES';
const CATECHILD = 'CATECHILD';
const BOOK_TRADITIONAL = 'BOOK_TRADITIONAL';
const BOOK_SHARE = 'BOOK_SHARE';
const BOOK_PRODUCT = 'BOOK_PRODUCT';
const BOOK_WHERE = 'BOOK_WHERE';
const BOOK_INFO = 'BOOK_INFO';
const TRUSTED_SHOP = 'TRUSTED_SHOP';
const ORDER_STORE = 'ORDER_STORE';
const ORDER_HIRING_BUY_SERVICE_STORE = 'ORDER_HIRING_BUY_SERVICE_STORE';
const REGISTER_PAY_ONE_TIME_SERVICE_STORE = 'REGISTER_PAY_ONE_TIME_SERVICE_STORE';
const PENDING_ORDER = 'PENDING_ORDER';
const LIST_BOOK_CASE = 'LIST_BOOK_CASE';
const LIST_PROVINCE_VIETNAM = 'LIST_PROVINCE_VIETNAM';
const HELP_QUESTION = 'HELP_QUESTION';
const MAILTO = 'MAILTO';
const SYSCACHE = 'SYSCACHE';
const USER_CACHE = 'USER_CACHE';

// COOKIE USER LOG
define(USER_COOKIE, $_COOKIE['u']);

// TIME DATE
define(_TIMESTAMP, date('Y-m-d H:i'));
// ROOT_DIR :
define('ROOT_DIR', dirname(__FILE__));
// UPLOADER DESTINATION
const PATH_URI_PX_UPLOAD_DES = URLBASE;
const IMG_CDN = '/img/cdn1';
const IMG_CDN_REAL_PHOTO = '/img/cdn-rp';
const IMG_CDN_EDITOR = '/img/cdn1_Editor';
