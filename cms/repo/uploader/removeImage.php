<?php
    include '../../../config.php';
    // JSON DATA FROM POST AJAX
    $jsonString = file_get_contents('php://input');
    //TRUE return Array
    $content = json_decode($jsonString, true);
    if ( $content['URL_IMAGE'] ){
        $file = str_replace(URLBASE, '', $content['URL_IMAGE']);
        // START REMOVE FILE ON DRIVE
        $path = ROOT_DIR.$file;
        $hasRemoved = unlink($path);
        if( $hasRemoved ){
            // SUCCESS:
            echo $file;
        }else{
            // FAILED
            echo 0;
        }
    }
?>