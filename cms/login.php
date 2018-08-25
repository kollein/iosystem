<?php
include '../config.php';
include '../function.php';
include '../autoload.php';
$content = $_POST['suggest'];
// FETCH FROM JSON
$email = $content['email'];
$phone_number = $content['phone_number'];
$password = $content['password'];
// SET DEFAULT : RETURN FALSE
$data_return['id'] = 0;
// CHECK TO AVOID EMPTY
if ( $content ) {
	// CHECK TO MAKING WHERE CONDITION
	if( $email ){
    	$where = "WHERE email = '$email'";
    }else{
    	$where = "WHERE phone_number = '$phone_number'";
    }
    	$where .= " AND group_id = 6";
	//call Class by Magic
    $ajaxData = new Model_sqlDynamic($conn, 0, 0);
    // FETCH WITH WHERE CONDITION
    $ajaxData->selectRow(USERS, $where);
    $user_finded = $ajaxData->_rendata[0];
    if( $user_finded ){
	    $salt = $user_finded['SALT'];
	    $md5_salt_from_sql_password = $user_finded['PASSWORD'];
	    $md5_salt_from_input_password = md5( md5($password).$salt );
	    // COMPARE FROM SQL AND INPUT
	    if( $md5_salt_from_input_password == $md5_salt_from_sql_password ){
	    	// HASH IMPORTANT
	    	$hash = alpha_numberic_hash(128);
	    	$data_return['id'] = $user_finded['ID'];
	    	$data_return['name'] = $name;
    		$data_return['email'] = $email;
	    }else{
	    	$data_return['error'] = 'password';
	    }
	}else{
		if( $email ){
			$data_return['error'] = 'email';
		}else{
			$data_return['error'] = 'phone_number';
		}
	}
	// FINAL CHECK TO UPDATE ONLINE_STATUS, HASH
	if( $data_return['id'] ){
		// PUSH HASH INTO DATA RETURN
		$data_return['hash'] = $hash;
		// UPDATE ONLINE_STATUS = 1, HASH = 30-chars
    	$query = "UPDATE USERS SET hash = '$hash', online_status = 1 $where";
    	$ajaxData->updateQuery($query);
    	$check_update = $ajaxData->_rendata;
    	if( !$check_update ){
			$data_return['error'] = 'UPDATE_ONLINE_STATUS';
		}
	}
	echo json_encode($data_return);
}
?>