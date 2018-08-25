<?php
    include '../../../../config.php';
    include '../../../../function.php';
    // JSON DATA FROM POST AJAX
    $jsonString = file_get_contents('php://input');
    //TRUE return Array
    $content = json_decode($jsonString, true);
    // var_dump($content);
    if ($content['NAME']) {
        $timestamp = time();
        $alphaRandom = alpha_numberic_hash(11);
        $filenameext = $timestamp.$alphaRandom. '.jpg';
        if($content['DESTINATE'] != ''){
            $destination = ROOT_DIR.'/'.$content['DESTINATE'];
        }else{
            $content['DESTINATE'] = IMG_CDN;
            $destination = ROOT_DIR.$content['DESTINATE'];//Default
        }

        $destination = ROOT_DIR.$content['DESTINATE'];
        //CACHED in: $base64IMG
        $base64IMG = $content['IMAGE'];
        // save IMAGE to SERVER
        $hasSaved = saveBase64Image($destination, $filenameext, $base64IMG);

        if( $hasSaved ){
            $selfURL = $content['DESTINATE'].'/'.$filenameext;
            $linkIMG = PATH_URI_PX_UPLOAD_DES.$selfURL;
            // UPDATE MYSQL: IF EDIT
            // RESPONSE A STRING: FileUrl for CKEDITOR
            echo '{"QUEUE_NAME":"'.$content['QUEUE_NAME'].'","URL_IMAGE":"'.$linkIMG.'"}';
        }else{
            //UPLOAD FAILED
            echo 0;
        }
    }
?>