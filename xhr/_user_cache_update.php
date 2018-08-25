<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

// JSON from SUBMIT FORM
$content = $_POST['suggest'];
//call Class by Magic
$ajaxData = new Model_sqlDynamic($conn);
// GET USER DATA
$user_data = $ajaxData->getUserWithHash();
// FETCH FROM JSON
$update_type = $content['statement'];
// CACHE DATA JSON
$cache_data_json = $content['content'];
// CLIENT IP
$client_ip = CLIENT_IP;
// DATA RETURN
$data_return['id'] = 0;
// CHECK USER HAS CACHE BEFORE OR NO
$where_user_id  = "WHERE user_id = {$user_data['ID']}";
$query_user_id = "SELECT *FROM USER_CACHE $where_user_id";
$ajaxData->selectQuery($query_user_id);
$user_cache_finded_user_id = $ajaxData->_rendata[0];
// CHECK IP_ADDRESS HAS CACHE BEFORE OR NO
$where_ip_address = "WHERE ip_address = '$client_ip' AND user_id < 1";
$query_ip_address = "SELECT *FROM USER_CACHE $where_ip_address";
$ajaxData->selectQuery($query_ip_address);
$user_cache_finded_ip_address = $ajaxData->_rendata[0];
// CHECK
if( $user_data['ID'] ){
    if( $user_cache_finded_user_id ){
        $where = $where_user_id;
        $force_type = 'update';
    }else{
        $force_type = 'insert';
    }
}else{
    if( $user_cache_finded_ip_address ){
        $where = $where_ip_address;
        $force_type = 'update';
    }else{
        $force_type = 'insert';
    }
}
// FORCE TYPE:
if( $force_type === 'update' ){
    $data_return['update'] = $where;
    // UPDATE CACHE FOR THIS USER
    $query = "UPDATE USER_CACHE SET $update_type = '{$cache_data_json}' $where";
    $ajaxData->updateQuery($query);
    if( $ajaxData->_rendata ){
            $data_return['id'] = $ajaxData->_rendata;
    }else{
            $data_return['error'] = "UPDATE_USER_CACHE_FAILED -> $update_type";
    }
}elseif( $force_type === 'insert' ){
    $data_return['insert'] = $where;
    // INSERT NEW ROW FOR THIS USER
    $query = "INSERT INTO USER_CACHE (user_id, $update_type, ip_address) VALUES
             ('{$user_data['ID']}', '$cache_data_json', '$client_ip')";
    $ajaxData->insertQuery($query);
    if( $ajaxData->_rendata ){
            $data_return['id'] = $ajaxData->_rendata;
    }else{
            $data_return['error'] = "INSERT_USER_CACHE_FAILED -> $update_type";
    }
}
echo json_encode($data_return);
?>