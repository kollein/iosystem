<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

$content = $_POST['suggest'];
// DATA CART
$data_cart = json_encode($content['data_cart']);
// KEY ORDER: is an ID for determind WHO intouch
$key_order = ($content['key_order'] ? $content['key_order'] : 0) + 0;
// USER ID
$user_id = $user_data['ID'];
// DATA RETURN
$data_return['id'] = 0;
// CHECK
if( $content ){
	//call Class by Magic
    $ajaxData = new Model_sqlDynamic($conn, 0, 0);
    // CHECK KEY_ORDER
    $where = "WHERE id = $key_order";
    $ajaxData->selectRow(PENDING_ORDER, $where);
    $key_finded = $ajaxData->_rendata[0];
    if ( $key_finded ) {
    	// UPDATE
    	$query = "UPDATE PENDING_ORDER SET user_id = '$user_id', content = '$data_cart' $where";
    	$ajaxData->updateQuery($query);
        // THIS STATEMENT OCCURS 2 CASES:
        // CASE: 1 UPDATED, CASE 2: NO-CHANGE, ANYMORE WE NEED SET TRUE ID ALWAYS
    	$lastid = $key_finded['ID'];
    }else{
    	// INSERT
		$query = "INSERT INTO PENDING_ORDER(user_id, content)VALUES('$user_id', '$data_cart')";
		$ajaxData->insertQuery($query);
		$lastid = $ajaxData->_rendata;
    }
    // FINAL CHECK
	if( $lastid ){
		$data_return['id'] = $lastid;
		$data_return['key_order'] = $lastid;
	}else{
		$data_return['error'] = 'PENDING_ORDER';
	}
	echo json_encode($data_return);
}
?>