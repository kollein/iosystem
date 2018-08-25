<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

// DATA FROM INPUT OF FORM
$content = $_POST['suggest'];
// STATEMENT
$statement = $content['statement'];
//call Class by Magic
$ajaxData = new Adapter_order($conn);
$user_data = $ajaxData->getUserWithHash();
// CHECK USER LOGGED OR NO: FOR UPDATE SOME INFO
if( $user_data['ID'] ){
	$content['user_id'] = $user_data['ID'];
	// UPDATE PHONE_NUMBER
	if( $content['phone_number'] ){
		$query = "UPDATE USERS SET phone_number = '{$content['phone_number']}' WHERE id = {$user_data['ID']}";
		$ajaxData->updateQuery($query);
	}
	// CHECK LSD
	$has_got_lsd = $ajaxData->calc_summary_lsd_got_by_all_exchange_order($user_data['ID'], 1);
	$has_used_lsd = $ajaxData->calc_summary_lsd_used_by_all_exchange_order($user_data['ID'], false);
	$valid_lsd_for_use_in_order = $has_got_lsd - $has_used_lsd;
	$content['use_lsd'] = $content['use_lsd'] > $valid_lsd_for_use_in_order ? $valid_lsd_for_use_in_order : $content['use_lsd'];
}else{
	$content['user_id'] = '0';
	$content['pay_one_time_status'] = '0';
}
// SET CONTENT IN CASE: QUICK ORDER
if( $statement == 'quick_order' ){
	$cart_data_json_str = json_encode($ajaxData->convert_str_structured_cart_to_arr($content['content']));
	$content['content'] = $cart_data_json_str;
}
// DECODE STRING JSON TO ARRAY
$cart_data_json = json_decode($content['content'], true);

// CALC SUMMARY CASH
$content['cash'] = $ajaxData->calc_summary_cash_per_order($cart_data_json);
// GET LSD BY CASH
$content['get_lsd'] = get_lsd_by_cash($content['cash']);
// SET IP ADDRESS
$content['ip_address'] = CLIENT_IP;
// MAP TO INSERT WITH
$map_insert_with = ['user_id', 'email', 'user_name', 'phone_number', 'address', 'content', 'notice', 'use_lsd', 'cash', 'get_lsd', 'ip_address', 'pay_one_time_status'];
// MAP TO ENCODE VALUE TO HTML-ENTITIES
$map_encode_html_entities = ['email', 'user_name', 'phone_number', 'address', 'notice'];
// MIX WITH MAP
$content_mixed = html_entities_by_map($content, $map_insert_with, $map_encode_html_entities);
// DATA RETURN
$data_return['id'] = 0;
// CHECK CART DATA
if( is_array($cart_data_json) && count($cart_data_json) > 0 ){
	$ajaxData_mix = new Model_sqlDynamic($conn, $content_mixed, 0);
	$NAME_VALUE = $ajaxData_mix->makeMixQueryMySQL('insert');
	$ajaxData_mix->insertRow(ORDER_STORE, $NAME_VALUE[0], $NAME_VALUE[1], false);
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