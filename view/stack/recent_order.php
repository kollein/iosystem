<div class="recent-order-wrapper">
<?php
// CHECK USER
if( $user_data['ID'] ){
	$where = "WHERE user_id = {$user_data['ID']} ORDER BY id DESC LIMIT 12";
	$mainRi->selectRow(ORDER_STORE, $where);
	$rowORDER_STORE_s = $mainRi->_rendata;
	if( $rowORDER_STORE_s ){
?>
<h2>Đơn hàng gần đây của bạn</h2>
<div id="recent-order" class="list-recent-order">
	<ul>
<?php
foreach( $rowORDER_STORE_s as $row ){
	if( $row['EXCHANGE_STATUS'] ){
		$type_shape = 'success';
		$data_tooltip = 'Giao dịch thành công';
	}else{
		$type_shape = 'waiting';
		$data_tooltip = 'Đang chờ giao dịch';
	}
?>
<li data-id="<?=$row['ID'];?>">
	<div class="date">
		<span class="_text"><?=formatDateFromTimestamp('d-m-Y H:i:s', $row['ORDER_DATE']);?></span>
		<div class="_icon ui-sign-shape" data-tooltip="<?=$data_tooltip;?>">
			<div class="square-16 <?=$type_shape;?>"></div>
		</div>
	</div>
	<div class="lsd" data-tooltip="Tiền tiết kiệm được">
		<span><?=number_format($row['GET_LSD'], 0, ',', '.');?></span><span class="lsd-icon _icon"></span>
	</div>
</li>
<?php
}
?>
	</ul>
</div>
<?php
	}else{
?>
<h2>Đơn hàng gần đây của bạn</h2>
<div class="list-rencent-order">
	<i>Không có đơn hàng nào</i>
</div>
<?php
	}
}else{
?>
<h3>Hãy đăng nhập để nhận tiền tiết kiệm khi mua hàng.</h3>
<a href="<?=generate_url_by_map([GO_USER, USER_LOGIN]);?>" class="rc-button yt-uix-button">Đăng nhập</a>
<a href="<?=generate_url_by_map([GO_USER, USER_SIGNUP]);?>" class="rc-button yt-uix-button">Đăng ký</a>
<?php
}
?>
</div>
<script>
var recent_order_li = new Popup_Invoke({
	containerID: 'recent-order',
	iterators: '.list-recent-order li',
	xhrURL: url_base + '/xhr/_view_recent_order/',
}).restart();
</script>