<?php
    include '../../../../config.php';
    // JSON DATA FROM POST AJAX
    $jsonString = file_get_contents('php://input');
    //TRUE return Array
    $content = json_decode($jsonString, true);
    if ( $content['URL_IMAGE'] ){
        $file = str_replace(URLBASE, '', $content['URL_IMAGE']);
        // START REMOVE FILE ON DRIVE
        $hasRemoved = unlink(ROOT_DIR.$file);
        if( $hasRemoved ){
            // SUCCESS:
            include '../../../../autoload.php';
            // call Class by Magic
            $ajaxData = new Model_sqlDynamic($conn, 0, 0);
            // UPDATE COLUMN: IMAGE
            $query = "UPDATE {$content['TABLE']} SET {$content['COLUMN_NAME']} = REPLACE({$content['COLUMN_NAME']}, '{$content['URL_IMAGE']}', '')";
            $ajaxData->updateQuery($query);
            // ALERT
            echo $file;
        }else{
            // FAILED
            echo 0;
        }
    }
?>