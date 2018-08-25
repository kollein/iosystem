<?php
include '../config.php';
include '../function.php';
$content = json_decode($_POST['suggest'], true);

//Init Magic :lazy loading
include '../autoload.php';
//call Class by Magic
//var_dump($content);
$ajaxData = new Model_sqlDynamic($conn, $content, 0);
$NAME_VALUE = $ajaxData->makeMixQueryMySQL('insert');
$ajaxData->insertRow(ORDERBILL, $NAME_VALUE[0], $NAME_VALUE[1], false);
echo $ajaxData->_rendata;
?>