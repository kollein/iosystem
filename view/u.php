<?php
if( in_array($curStack, [USER_LOGIN, USER_SIGNUP, USER_FORGOT_ACCOUNT]) ){
?>
<script>

    // IF HAS LOGIN, SO DONT NEED STAY HERE -> GO HOME
    if( data_user_json ){
        if( data_user_json['hash'] ){
            window.location.href = url_base;
        }
    }
</script>
<?php
}
?>
<script>
// ERROR DESCRIPTION
var map_error_after_submit = {
	'INSERT_NEW_MEMBER': 'Tạo mới bị thất bại.',
	'EMAIL_HAS_USED_BEFORE': 'Email đã có người sử dụng.',
	'PHONE_NUMBER_HAS_USED_BEFORE': 'Số điện thoại đã có người sử dụng.',
	'UPDATE_ONLINE_STATUS': 'Cập nhật hash và trạng thái online thất bại.',
    'UPDATE_FORGOT_ACCOUNT': 'Cập nhật mật khẩu mới tại forgotAccount thất bại',
	'password': 'Mật khẩu không đúng.',
	'email': 'Email này chưa đăng ký.',
	'phone_number': 'Số điện thoại này chưa đăng ký.'
}
var map_error_before_submit_login = {
    'password': 'Mật khẩu không đúng.',
	'repassword': 'Nhập lại mật khẩu không khớp.',
	'email': 'Email không tồn tại.',
	'phone_number': 'Số điện thoại không tồn tại.'
}
var map_error_before_submit_forgotAccount = map_error_before_submit_login;
var map_error_before_submit_signup = {
	'email': 'Email không hợp lệ, vd: abc@gmail.com',
	'phone_number': 'Số điện thoại không hợp lệ',
	'password': 'Mật khẩu ít nhất 6 ký tự.',
	'repassword': 'Nhập lại mật khẩu không khớp.'
}
var map_alias = {
	'signup': 'Bạn đã đăng ký thành công!',
	'login': 'Bạn đã đăng nhập thành công!',
    'forgotAccount': 'Bạn đã gửi thành công, hãy kiểm tra hộp thư để nhận thông tin đăng nhập tài khoản.'
}
</script>
<?php
if( !in_array($curStack, [USER_PROFILE]) ){
?>
<script>
$(function(){

    //FORM ORDER_STORE: submit
    var $form_login = $('form#<?=$curStack;?>');
    $form_login.submit(function(event){
        // STOP submit default by browser
        event.preventDefault();
        // DATA format with JSON
        var streamInput = {}
        // TEMPORARY FOR COMPARE AFTER
        var repassword_value, password_value;
        // DEFINE EMAIL OR PHONE_NUMBER LOGIN CASE
        var define_login_with_e_p = 'phone_number';
        var email_or_phone_number = $('input[name="email:phone_number"]').val();
        if( email_or_phone_number.indexOf('@') > 1 ){
        	define_login_with_e_p = 'email';
        }
        var $lis = $(this).find('input');
        $lis.each(function(){
            var name = $(this).attr('name');
            var value = $(this).val().toString().trim();
            // REMANEM @name WITH DEFINE LOGIN
            if( name == 'email:phone_number' ){
            	name = define_login_with_e_p;
            }
            // CASE: SIGNUP
            if( name == 'password' ){
                password_value = value;
            }
            if( name == 'repassword' ){
                repassword_value = value;
            }
            // CHECKING:
            // set default to avoid error
            var pattern = /\s*/g;
            if( name == 'content' & value.length > 0 ||
                name == 'user_name' & value.length > 2 ||
                name == 'address' & value.length > 5 ||
                name == 'password' & value.length > 2 ||
                name == 'repassword' & password_value == repassword_value
            ){
                //NOT USE REGX, check by length
                //DONT DO HERE, ELSE case: will do for these
            }else if( name == 'phone_number' ){
                pattern = /[0-9 ]{9,14}/g;
            }else if( name == 'email' ){
                pattern = /^\w{3,}@\w+\.[a-z]{2,}/gi;
            }else{
                // Made pattern always test return FALSE
                pattern = /^\s/g;
            }
            //CHECK BY @pattern
            if( pattern.test(value) ){
                $(this).removeClass('error');
                //push VALUE to JSON DATA
                streamInput[name] = value;
            }else{
                $(this).focus();
                $(this).addClass('error');
                $('.error-text').text(map_error_before_submit_<?=$curStack;?>[name]);
                return false;
            }
            //FINAL SHOOT: send-to-server
            if($(this)[0] === $lis.last()[0]) {
                //this is the last one
                console.log(streamInput);
                // VIETNAMESE NOTCIE ERROR:
                streamInput['login_type'] = '<?=$curStack;?>';
                send_to_server_login(streamInput);
            }
        });
    });

});
</script>
<script>
// FACEBOOK SDK - LOGIN
window.fbAsyncInit = function() {
    FB.init({
        appId: '658077687715916',
        cookie: false, // enable cookies to allow the server to access 
        xfbml: true,
        version: 'v2.10'
    });
    // CHECK FOR LOGOUT
    FB.getLoginStatus(function(response) {
        console.log(response);
        if( response.status === 'connected' ){
            if( '<?=$curStack;?>' === '<?=USER_LOGOUT;?>' ){
                logoutWithFB('<?=$curStack;?>');
            }else{
                loginWithFB();
            }
        }
    });
};
// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
// NOTICE: METHOD CALL AFTER SDK LOADED BEFORE
// LOGIN : OPEN NEW TAB WITH FB LOGIN
function loginWithFB(){
    if( FB ){
        console.log('Instance has initial!');
    }else{
        console.log('Network not working!');
    }
    FB.login(function(response) {
        console.log(response);
        if ( response.status === 'connected' ) {
            get_info_from_API();
        } else {
            // The person is not logged into this app or we are unable to tell. 
            console.log('Failed login with FB');
        }
    });
}
// GET INFO FROM API FB
function get_info_from_API() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        // NOTICE: HERE NO RECIEVE ANY VARIABLE FROM WINDOW OBJECT
        // COLLECTION INFO FROM API
        var dataAuthorize = {}
        dataAuthorize['login_type'] = 'facebook-sdk';
        dataAuthorize['id_facebook'] = response.id;
        dataAuthorize['name'] = response.name;
        dataAuthorize['email'] = response.email;
        // FINAL SEND
        send_to_server_login(dataAuthorize);
    });
}
// SEND TO SERVER FOR CHECK
function send_to_server_login(dataAuthorize){
    console.log(dataAuthorize);
    $.post( url_base + '/xhr/_user_login/', {suggest:dataAuthorize} ).done(function(data){
        data = JSON.parse(data);
        console.log(data);
        if( data.id ){
            setCookie('u', JSON.stringify(data), 1);
            $('.error-text').text(map_alias['<?=$curStack;?>']).css('color', '#000');
            console.log('Successful!');
            if( data.login_type == '<?=USER_FORGOT_ACCOUNT;?>' ){
                $('form button').attr('disabled', 'disabled');
            }else{
                window.location.href = '<?=URLBASE.'/'.GO_GUIDING.'/'.GUIDING_MEMBER.'/';?>';
            }
        }else{
            $('.error-text').text(map_error_after_submit[data.error]);
            console.log('Failed!');
            $('input[name="' + data.error + '"').focus().addClass('error');
        }
    });
}
// LOGOUT
function logoutWithFB(curStack){
    FB.logout(function(response) {
        // user is now logged out
        console.log(response);
        console.log(curStack);
        if( curStack == '<?=USER_LOGOUT;?>' ){
            window.location.href = url_base;
        }
    });
}
</script>
<?php
}
?>
<?php
if( $curStack == USER_PROFILE && $user_data['ID'] ){
    include'view/stack/profile.php';
}elseif( $curStack == USER_LOGIN ){
    include'view/stack/login.php';
}elseif( $curStack == USER_SIGNUP ){
    include'view/stack/signup.php';
}elseif( $curStack == USER_FORGOT_ACCOUNT ){
    include'view/stack/forgotAccount.php';
}else{
    include'view/stack/logout.php';
}
?>