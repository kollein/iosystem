<?php
include '../config.php';
include '../function.php';
include'../autoload.php';
// insert Data into main Interface , html
// init Main Root Information from Autoload Technique
$cms = new Model_sqlDynamic($conn);
/*
    METHOD, DATA : FOR USE ALWAYS IN SYSTEM
*/
// GET USERS: FROM @funcdynamic.php
$user_data = $cms->getUserWithHash();
if( !$user_data['ID'] ){
    // STATEMENT: BEFORE the <html> tag : DELETE USER_COOKIE
    setcookie("u", "", time() - 3600);
}
/*parameter in GET be shown in .htacess file
** This list query is important to know yourrequest
** Special, form.php different to index.php at [$curId, $curPid]
*/
$curAdapter = $_GET['adapter'];//same as cates_id
$curCatechildid = $_GET['catechild_id']+0;//maybe: catechild_id
$curPostid = $_GET['postid']+0;//maybe: postid
// CHECK @$curAdapter: for SEARCH or NULL
if( !$curAdapter ){
    $curAdapter = 1;//default CATES -> ID=1
}

// FETCH CATES
$cms->selectRow(CATES, 'ORDER BY ord');
$cateMapRoot = $cms->_rendata;//index by 0 ++
// Recursive Key increasing 1+ all index-key in Object Data to AVOID 0 index
$cateMap = plusIDXArr($cateMapRoot, 1);
// GET THIS CATE
$thisCate = getThisCate($cateMap, $curAdapter, 'id');
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0"/>
    <meta charset="utf-8"/>
    <link rel="shortcut icon" href="<?= URLBASE; ?>/cms/logo.ico" type="image/x-icon"/>
    <script src="<?=URLBASE;?>/cms/js/all.js"></script>
    <link rel="stylesheet" href="<?=URLBASE;?>/cms/css/style.css" type="text/css"/>
    <link href="<?=URLBASE;?>/cms/repo/stack/_editor/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?=URLBASE;?>/cms/repo/stack/_image/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if( $user_data['GROUP_ID'] == 6 ){
    include 'template.php';
}else{
?>
<div id="login-container">
    <div class="loginForm yt-card3">
        <div class="error-text"></div>
        <form id="login-cms">
            <div class="bound-form-control">
                <input class="form-control" type="text" name="email:phone_number"/>
                <label class="label-place-top">
                    <span class="label-title">Số điện thoại hoặc Email</span>
                </label>
            </div>
            <div class="bound-form-control">
                <input class="form-control" type="password" name="password"/>
                <label class="label-place-top">
                    <span class="label-title">Mật khẩu</span>
                </label>
            </div>
            <div class="bound-button">
                <button type="submit" class="_login_btn _btn _btn-b" data-ripple>Login</button>
            </div>
        </form>
    </div>
</div>
<script>
// INVOKE FORM CONTROL
EffectiveComposer.restartFormControl();
// ERROR TEXT MAP
var map_error_before_submit_login = {
    'password': 'Mật khẩu không đúng.',
    'repassword': 'Nhập lại mật khẩu không khớp.',
    'email': 'Email không tồn tại.',
    'phone_number': 'Số điện thoại không tồn tại.'
}
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
$(function(){

    //FORM ORDER_STORE: submit
    var $form_login = $('form#login-cms');
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
                $('.error-text').text(map_error_before_submit_login[name]);
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
    // SEND TO SERVER FOR CHECK
    function send_to_server_login(dataAuthorize){
        console.log(dataAuthorize);
        $.post( 'login.php', {suggest:dataAuthorize} ).done(function(data){
            data = JSON.parse(data);
            console.log(data);
            if( data.id ){
                setCookie('u', JSON.stringify(data), 1);
                setTimeout(function(){
                    // window.location.reload();
                }, 500);
            }else{
                $('.error-text').text(map_error_after_submit[data.error]);
                console.log('Failed!');
                $('input[name="' + data.error + '"').focus().addClass('error');
            }
        });
    }
});
</script>
<?php
}
?>
<div id="recycle"></div>
</body>
</html>