<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

// DATA FROM INPUT OF FORM
$content = $_POST['suggest'];
//call Class by Magic
$ajaxData = new Model_sqlDynamic($conn);
$user_data = $ajaxData->getUserWithHash();
// CHECK USER LOGGED OR NO
if( $user_data['ID'] ){
	$content['user_id'] = $user_data['ID'];
	// UPDATE PHONE_NUMBER
	if( $content['phone_number'] ){
		$query = "UPDATE USERS SET phone_number = '{$content['phone_number']}' WHERE id = {$user_data['ID']}";
		$ajaxData->updateQuery($query);
	}
}
// DECODE TO JSON
$cart_data_json =  $content;
// SET IP ADDRESS
$content['ip_address'] = CLIENT_IP;
// MAP TO INSERT WITH
$map_insert_with = ['user_id', 'user_name', 'phone_number', 'content', 'ip_address'];
// MAP TO ENCODE VALUE TO HTML-ENTITIES
$map_encode_html_entities = ['user_name', 'phone_number', 'content'];
// MIX WITH MAP
$content_mixed = html_entities_by_map($content, $map_insert_with, $map_encode_html_entities);
// DATA RETURN
$data_return['id'] = 0;
// CHECK CART DATA
if( is_array($cart_data_json) && count($cart_data_json) > 0 ){
	$ajaxData_mix = new Model_sqlDynamic($conn, $content_mixed, 0);
	$NAME_VALUE = $ajaxData_mix->makeMixQueryMySQL('insert');
	$ajaxData_mix->insertRow(ORDER_HIRING_BUY_SERVICE_STORE, $NAME_VALUE[0], $NAME_VALUE[1], false);
    if( $ajaxData_mix->_rendata ){
    	$data_return['id'] = 1;
    	$data_return['success_alert'] = '<h1 class="center">Đặt hàng thành công, chúng tôi sẽ liên hệ với bạn ngay.</h1>';
    }else{
    	$data_return['error'] = 'INSERT_FAILED';
    }
}else{
	$data_return['error'] = 'CONTENT_CART_WRONG';
}
echo json_encode($data_return);
?>