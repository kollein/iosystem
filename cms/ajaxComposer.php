<?php
if ($_POST['suggest']) {

    include '../config.php';
    include '../function.php';
    // MAIN DATA
    $content = $_POST['suggest'];
    // QUERY DATA
    $dataQuery = $_POST['dataQuery'];
    $TABLE = $dataQuery['table'];
    $statment = $dataQuery['statment'];

var_dump($dataQuery);
    //Init Magic :lazy loading
    include '../autoload.php';
    if ( $statment == 'new' ) {

        //call Class by Magic
        $ajaxData = new Model_sqlDynamic($conn, $content, 0);
        $NAME_VALUE = $ajaxData->makeMixQueryMySQL('insert');

        // save IMAGE to SERVER
        if ($hasIMGupload) {
            saveBase64Image($destination, $filenameext, $base64IMG);
        }
        //var_dump($NAME_VALUE);
        $ajaxData->insertRow($TABLE, $NAME_VALUE[0], $NAME_VALUE[1], false);
        echo $ajaxData->_rendata;
        //MAILTO
        if($TABLE == 'MAILTO'){
            //include'../module/mail.php';
        }
    } elseif ( $statment == 'edit' ) {
        // call Class by Magic
        $ajaxData = new Model_sqlDynamic($conn, $content, 0);
        $NAME_VALUE = $ajaxData->makeMixQueryMySQL('update');
        $where = "WHERE id = " . $content['ID'];
        // $NAME_VALUE[1] : include KEY-NAME & VAL-VALUE
        $ajaxData->updateRow($TABLE, $NAME_VALUE[1], $where, false);
        // ALERT
        if ($ajaxData->_rendata > 0) {
            echo $content['ID'];
        }
    } elseif ($statment == 'delete') {
        //call Class by Magic
        $ajaxData = new Model_sqlDynamic($conn, $content, 0);
        $where = "WHERE id=";
        $ajaxData->deleteRow($TABLE, $where, true);
    }

}
?>