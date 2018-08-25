<?php
// INHERIT FROM RESOURCE
if( $user_data['HASH'] ){
	$name_display = $user_data['NAME'] ? $user_data['NAME'] : ($user_data['EMAIL'] ? $user_data['EMAIL'] : 'bạn');
	//call Class by Magic
	$orderData = new Adapter_order($conn);
	// CALC SUMMARY LSD GOT
	$has_got_lsd = $orderData->calc_summary_lsd_got_by_all_exchange_order($user_data['ID'], 1);
	$has_used_lsd = $orderData->calc_summary_lsd_used_by_all_exchange_order($user_data['ID'], false);
	$valid_lsd_for_use_in_order = $has_got_lsd - $has_used_lsd;

?>
<div class="user-wrapper">
	<div class="avatar">
		<div class="circle" data-ripple="rgb(0,0,0)"></div>
	</div>
	<div class="drop-down-menu">
		<div class="display-username">
			<div class="text">Tài khoản: <span class="name"><?=$name_display;?></span></div>
		</div>
		<ul>
			<li><a href="<?=generate_url_by_map([GO_USER, USER_PROFILE]);?>">Trang cá nhân</a></li>
		</ul>
		<div class="grey-box coin-box" title="Tiền tiết kiệm (LSD) hiện có">
			<a href="<?=generate_url_by_map([GO_USER, USER_PROFILE, '?'.USER_PROFILE_QUERY_ALIAS.'='.USER_PROFILE_LSD]);?>">
				<div class="icon-coin"></div>
				<div class="text-coin"><?=number_format($valid_lsd_for_use_in_order, 0, ',', '.');?></div>
			</a>	
		</div>
		<div class="grey-box">
			<a class="a-btn rc-button yt-uix-button" href="<?=generate_url_by_map([GO_USER, USER_LOGOUT]);?>">Đăng xuất</a>
		</div>
	</div>
</div>
<?php
}else{
?>
<a class="a-log-btn rc-button yt-uix-button" href="<?=generate_url_by_map([GO_USER, USER_LOGIN]);?>">Đăng nhập</a>
<?php
}
?>
<script>
// STOP BUBBLE
$('#userlog-container .drop-down-menu').on('mousedown', function(event){
    event.stopPropagation();
});
// TOGGLE DROP DOWN MENU
$('#userlog-container .avatar').on('mousedown', function(event){
	event.stopPropagation();
	$(this).next().toggle();
});
</script>