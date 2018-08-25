<section id="show-container" class="block-container">
    <div class="profile-container ui-wrapper yt-card">
<?php
// UPDATE ONLINE_STATUS = 0, HASH = ''
$query = "UPDATE USERS SET hash = '', online_status = 0 WHERE hash = '{$user_data['HASH']}'";
$mainRi->updateQuery($query);
$check_update = $mainRi->_rendata;
if( !$check_update ){
    $error = 'Logout error with update status!';
}
echo '<h2>Thành công...đang chuyển về trang chủ</h2>';
?>
    </div>
</section>
<script>
// LOGOUT: BY HOST
deleteCookie('u');
/*
WE NEED INVOKE:
logoutWithFB(): BECAUSE API's LAZY LOAD
SO WE CANT KNOW WHEN FB HAS LOGOUT
UNLESS USE SELF API, THEN GO HOME
*/
setTimeout(function(){
	window.location.href = url_base;
}, 1500);
</script>