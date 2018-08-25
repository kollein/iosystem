<?php
include '../config.php';
include '../function.php';
$opt = $_GET['opt'];
$key = trim($_GET['prop']);
if ($opt == 'genyouset' & $key != '') {

    if(!$_GET['action']){
        
        $newValue = trimChar('Ofcache', $_GET['nv']);
        $crazy = $_GET['crazy'];
        $stream = showCache($crazy);
        $cache_strJSON = jsonUpdatedStrOutput($stream, $key, $newValue);
        //NATIVE MySQL PDO
        $conn->query( "UPDATE " . SYSCACHE . " SET cache='$cache_strJSON' WHERE crazy='{$crazy}'" ) or die('DIE');
    }else{
        
        if($_GET['action'] == 'add'){
            $delete = false;
        }else{
            $delete = true;
        }
        $newValue = "";
        $runSQLwithMap = array("en", "vn");
        foreach($runSQLwithMap as $crazy){
            $stream = showCache($crazy);
            $cache_strJSON = jsonUpdatedStrOutput($stream, $key, $newValue, $delete);
            //NATIVE MySQL PDO
            $conn->query( "UPDATE " . SYSCACHE . " SET cache='$cache_strJSON' WHERE crazy='{$crazy}'" ) or die('DIE');
        }
    }

    
}

function jsonUpdatedStrOutput($stream, $key, $newValue, $delete = false){
    $cache_mixJSON = json_decode($stream, true);
    if($delete){
        unset($cache_mixJSON[$key]);
    }else{
        $cache_mixJSON[$key] = $newValue;
    }
    return json_encode($cache_mixJSON, JSON_UNESCAPED_UNICODE);
}
?>