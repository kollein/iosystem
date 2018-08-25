<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

// JSON from SUBMIT FORM
$content = $_POST['suggest'];
$content_for_mixed = $content;
unset($content_for_mixed['statement']);
//call Class by Magic
$ajaxData = new Model_sqlDynamic($conn, $content_for_mixed, 0);
// GET USER DATA
$user_data = $ajaxData->getUserWithHash();
// USER DATA FROM @adapter.php FETCHED
$hash = $user_data['HASH'];
// FETCH FROM JSON
$update_type = $content['statement'];
$email = $content['email'];
$phone_number = $content['phone_number'];
// DATA RETURN
$data_return['id'] = 0;
// WHERE CONDITION BY USER HASH
$where = "WHERE hash = '$hash'";
// CHECK ISSET
if( $user_data ){
    
        if( $update_type == 'basic-info' ){

                // MAKE DATA STRUCTURE: NAME = VALUE
                $NAME_VALUE = $ajaxData->makeMixQueryMySQL('update');
                // $NAME_VALUE[1] : include KEY-NAME & VAL-VALUE
                $query = "UPDATE USERS SET {$NAME_VALUE[1]} $where";
                $ajaxData->updateQuery($query);
                // ALERT
                if( $ajaxData->_rendata ){
                        $data_return['id'] = $user_data['ID'];
                }else{
                        $data_return['error'] = 'UPDATE_NO_CHANGE';
                }

        }elseif( $update_type == 'phone-number' ){

                $where_phone_number = "WHERE phone_number = '$phone_number'";
                // FETCH WITH WHERE CONDITION
                $ajaxData->selectRow(USERS, $where_phone_number);
                $user_data_with_phone_number = $ajaxData->_rendata[0];
                if( !$user_data_with_phone_number ){

                        $query = "UPDATE USERS SET phone_number = '$phone_number' $where";
                        $ajaxData->updateQuery($query);
                        // ALERT
                        if( $ajaxData->_rendata ){
                                $data_return['id'] = $user_data['ID'];
                        }else{
                                $data_return['error'] = 'UPDATE_NO_CHANGE';
                        }
                }else{
                        if( $user_data_with_phone_number['ID'] == $user_data['ID'] ){
                                $data_return['error'] = 'UPDATE_NO_CHANGE';
                        }else{
                                // SOMEONE USED THIS PHONE NUMBER
                                $data_return['error'] = 'PHONE_NUMBER_HAS_USED_BEFORE';
                        }
                }

        }elseif( $update_type == 'email' ){

                $where_email = "WHERE email = '$email'";
                // FETCH WITH WHERE CONDITION
                $ajaxData->selectRow(USERS, $where_email);
                $user_data_with_email = $ajaxData->_rendata[0];
                if( !$user_data_with_email ){

                        $query = "UPDATE USERS SET email = '$email' $where";
                        $ajaxData->updateQuery($query);
                        // ALERT
                        if( $ajaxData->_rendata ){
                        	$data_return['id'] = $user_data['ID'];
                        }else{
                        	$data_return['error'] = 'UPDATE_NO_CHANGE';
                        }
                }else{
                        if( $user_data_with_email['ID'] == $user_data['ID'] ){
                                $data_return['error'] = 'UPDATE_NO_CHANGE';
                        }else{
                                // SOMEONE USED THIS EMAIL
                                $data_return['error'] = 'EMAIL_HAS_USED_BEFORE';
                        }
                }

        }elseif( $update_type == 'password' ){

                $password = $content['password'];
                $salt = alpha_numberic_hash(3);
                $md5_salt_from_input_password = md5( md5($password).$salt );
                // UPDATE
                $query = "UPDATE USERS SET password = '$md5_salt_from_input_password', salt = '$salt', forgot_account_new_password = '' $where";
                $ajaxData->updateQuery($query);
                // ALERT
                if( $ajaxData->_rendata ){
                	$data_return['id'] = $user_data['ID'];
                }else{
                	$data_return['error'] = 'UPDATE_NO_CHANGE';
                }

        }
}else{
	$data_return['error'] = 'HASH_EXPIRED';
}
// FINAL ASSIGN: SUCCESS ALERT
if( $data_return['id'] ){
        $data_return['success_alert'] = '<h2 class="center">Bạn đã lưu thành công!</h2>';
}
echo json_encode($data_return);
?>