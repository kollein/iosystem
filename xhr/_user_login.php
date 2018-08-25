<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

$content = $_POST['suggest'];
// INIT VALUES
$login_type = $content['login_type'];
$email = $content['email'];
$phone_number = $content['phone_number'];
$id_facebook = $content['id_facebook'];
$password = $content['password'];
$ip_address = CLIENT_IP;
// CHECK
if ( $content ) {
	if( $login_type == 'facebook-sdk' ){
		// WITH FB
	    $where = "WHERE id_facebook = '$id_facebook'";
	}else{
		if( $email ){
	    	$where = "WHERE email = '$email'";
	    }else{
	    	$where = "WHERE phone_number = '$phone_number'";
	    }
	}
	//call Class by Magic
    $ajaxData = new Model_sqlDynamic($conn);
    // FETCH WITH WHERE CONDITION
    $ajaxData->selectRow(USERS, $where);
    $user_finded = $ajaxData->_rendata[0];
	// INIT DATA RETURN TYPE JSON
    $data_return['id'] = 0;
    $data_return['login_type'] = $login_type;
    // HASH FOR NEW LOGIN
	$hash = alpha_numberic_hash(128);
    // CHECK LOGIN TYPE
    if( $login_type == LOGIN_FACEBOOK_SDK ){
    	// LOGIN & SIGNUP BY FACEBOOK SDK
    	$name = $content['name'];
    	/* 
    	LOGIN WITH FB: 
		- CASE 1: LOGIN FIRST -> INSERT NEW USER
		- CASE 2: LOGIN NORMAL -> CHECK ID_FACEBOOK	
    	*/ 
    	if( !$user_finded ){
    		// CASE 1:
    		$query = "INSERT INTO USERS(id_facebook, name, email, ip_address)VALUES('$id_facebook', '$name', '$email', '$ip_address')";
    		$ajaxData->insertQuery($query);
    		$lastid_insert = $ajaxData->_rendata;
    		if( $lastid_insert ){
    			$data_return['id'] = $lastid_insert;
    			$data_return['name'] = $name;
	    		$data_return['email'] = $email;
	    		$data_return['notice'] = 'NEW_MEMBER';
    		}else{
    			$data_return['error'] = 'INSERT_NEW_MEMBER';
    		}
    	}else{
    		// CASE 2:
    		$data_return['id'] = $user_finded['ID'];
    		$data_return['name'] = $user_finded['NAME'];
    		$data_return['email'] = $user_finded['EMAIL'];
    		$data_return['notice'] = 'OLD_MEMBER';
    	}
    }elseif( $login_type == USER_SIGNUP ){

    	// SIGNUP NORMAL
    	if( !$user_finded ){
	    	$salt = alpha_numberic_hash(3);
	    	$md5_salt_from_input_password = md5( md5($password).$salt );
	    	$query = "INSERT INTO USERS(email, phone_number, password, salt, ip_address)VALUES('$email', '$phone_number', '$md5_salt_from_input_password', '$salt', '$ip_address')";

			$ajaxData->insertQuery($query);
			$lastid_insert = $ajaxData->_rendata;
			if( $lastid_insert ){
				$data_return['id'] = $lastid_insert;
				$data_return['name'] = $name;
	    		$data_return['email'] = $email;
	    		$data_return['notice'] = 'NEW_MEMBER';
			}else{
				$data_return['error'] = 'INSERT_NEW_MEMBER';
			}
		}else{
			if( $email ){
				$data_return['error'] = 'EMAIL_HAS_USED_BEFORE';
			}else{
				$data_return['error'] = 'PHONE_NUMBER_HAS_USED_BEFORE';
			}
		}
    }elseif( $login_type == USER_LOGIN ){

    	// LOGIN NORMAL
	    if( $user_finded ){
		    $salt = $user_finded['SALT'];
		    $md5_salt_from_sql_password = $user_finded['PASSWORD'];
		    $md5_salt_from_input_password = md5( md5($password).$salt );
		    // COMPARE FROM SQL AND INPUT
		    if( $md5_salt_from_input_password == $md5_salt_from_sql_password ){
		    	
	    		$data_return['id'] = $user_finded['ID'];
	    		$data_return['name'] = $user_finded['NAME'];
	    		$data_return['email'] = $user_finded['EMAIL'];
		    	
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
	}elseif( $login_type == USER_FORGOT_ACCOUNT ){
		// FORGOT ACCOUNT
		if( $user_finded ){
		    $salt = alpha_numberic_hash(3);
		    $new_password = alpha_numberic_hash(4);
		    $md5_salt_from_new_password = md5( md5($new_password).$salt );
		    // UPDATE SALT, PASSWORD
	    	$query = "UPDATE USERS SET salt = '$salt', password = '$md5_salt_from_new_password', forgot_account_new_password = '$new_password' $where";
	    	$ajaxData->updateQuery($query);
	    	$check_update = $ajaxData->_rendata;
	    	if( $check_update ){
	    		$data_return['id'] = $user_finded['ID'];
			}else{
				$data_return['error'] = 'UPDATE_FORGOT_ACCOUNT';
			}
		}else{
		    if( $email ){
				$data_return['error'] = 'email';
			}else{
				$data_return['error'] = 'phone_number';
			}
		}
	}
	// FINAL CHECK TO UPDATE ONLINE_STATUS, HASH
	if( $data_return['id'] && in_array($login_type, [USER_LOGIN, USER_SIGNUP, LOGIN_FACEBOOK_SDK]) ){
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
	// RETURN CLIENT AS JSON DATA
    echo json_encode($data_return);
}
?>