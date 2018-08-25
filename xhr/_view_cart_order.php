<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

//call Class by Magic
$ajaxData = new Adapter_order($conn);
// GET USER DATA
$user_data = $ajaxData->getUserWithHash();
// JSON from POST AJAX
// REVERSE TO SEE LAST ADDED AT TOP
$cart_data_json = is_array($_POST['suggest']) ? array_reverse($_POST['suggest']) : $_POST['suggest'];
?>
    <div class="edit-wrapper">
        <span>Chọn hết</span>
        <a id="delete-ticked-item">Xóa</a>
        <span class="number-item-cart-checked">(0)</span>
    </div>
    <table cellpadding="0">
        <thead>
<tr>
    <td class="checkall">
        <div class="tick-all">
            <div class="checkbox-container" aria-check="false">
                <div class="checkbox"></div>
                <div class="paper-ripple"></div>
            </div>
        </div>
    </td>
    <td class="title"><div class="inline">Tên sản phẩm</div></td>
    <td class="image"><div class="inline">Ảnh</div></td>
    <td class="price"><div class="inline">Giá</div></td>
    <td class="amount"><div class="inline">Số lượng</div></td>
    <td class="summary"><div class="inline">Tổng</div></td>
</tr>
        </thead>
        <tbody class="body">
<?php
// CHECK : @cart_data_json MUST IS ARRAY
if ( is_array($cart_data_json) ){
    // FETCHED DATA FROM CART DATA JSON
    $rowBOOK_s = $ajaxData->get_data_from_cart_data_json($cart_data_json);
    // CHECK FETCHED DATA FROM BOOK
    if( $rowBOOK_s ){
        // SOME INFO AFTER DONE
        $sumary_cash = 0;
        // FINAL: SHOWTIME & SORT BY NATURAL
        foreach( $cart_data_json as $id => $none ){
            $map_alias_id_item = $ajaxData->generate_map_cart_item_id($id);
            $row = $ajaxData->find_row_item_by_map_alias_id($rowBOOK_s, $map_alias_id_item);
            $getIMG = get_link_img_from_str($row['IMAGE']);
            $urlTitle = convertAlias($row['TITLE'],true);
            $go_by_bookcase = strtolower( substr( $row['BOOK_CASE'], 0, 1 ) );
            $url_go_post = generate_url_by_map([$go_by_bookcase, $row['ID'], $urlTitle], true, true);
            $mixed_id = $go_by_bookcase.'_'.$row['ID'];
            $item_amount = $cart_data_json[$mixed_id][0]['amount'];
            $summary_line = $row['PRICE'] * $item_amount;
            $sumary_cash += $row['PRICE'] * $item_amount;
?>
<tr>
    <td>
        <div class="check-col">
            <div class="checkbox-container" aria-check="false" data-id="<?=$go_by_bookcase.'_'.$row['ID'];?>">
                <div class="checkbox"></div>
                <div class="paper-ripple"></div>
            </div>
        </div>
    </td>
    <td><div class="inline"><?=$row['TITLE'];?></div></td>
    <td>
        <a href="<?=$url_go_post;?>">
            <div class="cover">
                <img class="imgScaledown" src="<?=$getIMG[0];?>"/>
            </div>
        </a>
    </td>
    <td><div class="inline"><?=number_format($row['PRICE'], 0, ",", ".");?></div></td>
    <td><div class="inline"><input name="order-amount-column" data-cart="id=<?=$map_go_view['BOOK_'.$row['BOOK_CASE']].'_'.$row['ID'];?>|amount=<?=$item_amount;?>" type="number" value="<?=$item_amount;?>" /></div></td>
    <td><div class="inline"><?=number_format($summary_line, 0, ",", ".");?></div></td>
</tr>
<?php
        }
    }
}else{
	$empty_alert = '<div class="empty-alert">Không có sản phẩm trong giỏ hàng, <a href="'.URLBASE.'">Tiếp tục mua hàng</a></div>';
?>
<tr>
	<td>....</td>
</tr>
<?php
}
?>
<tr class="summary-line">
    <td>&nbsp;</td>
    <td><div class="inline">Tổng cộng:</div></td>
    <td><div class="inline">&nbsp;</div></td>
    <td><div class="inline">&nbsp;</div></td>
    <td><div class="inline">&nbsp;</div></td>
    <td><div class="inline"><b><?=number_format($sumary_cash, 0, ',', '.');?></b></div></td>
</tr>
<?php
$valid_lsd_for_use_in_order = 0;
// MEMBER ORDER
if( $user_data['ID'] ){
    $has_got_lsd = $ajaxData->calc_summary_lsd_got_by_all_exchange_order($user_data['ID'], 1);
    $has_used_lsd = $ajaxData->calc_summary_lsd_used_by_all_exchange_order($user_data['ID'], false);
    $valid_lsd_for_use_in_order = $has_got_lsd - $has_used_lsd;
?>
<tr class="summary-line">
    <td>&nbsp;</td>
    <td><div class="inline">Sử dụng tiền tiết kiệm <a href="<?=generate_url_by_map([GO_HELP, HELP_FAQ, '?question=1']);?>">[?]</a></div></td>
    <td><div class="inline">&nbsp;</div></td>
    <td><div class="inline"><input id="use-lsd-in-order" type="number" min="0" max="<?=$valid_lsd_for_use_in_order;?>" value="<?=$valid_lsd_for_use_in_order;?>"/></div></td>
    <td><div class="inline">còn lại:</div></td>
    <td><div class="inline final-summary-cash"></div></td>
</tr>
<?php
}
?>
        </tbody>
    </table>
	<div class="order-form-wrapper">
        <form id="order" class="form-submit">
			<div class="error-text"></div>
<?php
// GUEST OR MEMBER NO PHONE_NUMBER : REQUIRE
if( !$user_data['ID'] || strlen($user_data['PHONE_NUMBER']) < 10 ){
?>
            <h3>Xin cung cấp số điện thoại để liên hệ khi giao hàng:</h3>
			<div class="bound-form-control">
			    <input class="form-control" data-require="1" type="text" name="phone_number" autofocus />
			    <label class="label-place-top">
			        <span class="label-title">Số điện thoại</span>
			    </label>
			</div>
<?php
}
// MEMBER USING PAY ONE TIME SERVICE OR NO
$where = "WHERE user_id = {$user_data['ID']} AND register_status = 1";
$ajaxData->selectRow(REGISTER_PAY_ONE_TIME_SERVICE_STORE, $where);
$rowPOT = $ajaxData->_rendata[0];
if( $rowPOT ){
    // GET PACKAGE PRICE WHICH MEMBER IN USING
    $package_price = $rowPOT['PACKAGE_PRICE'] * 1000;
    // CALC BETWEEN TWO TIMESTAMP OF THIS MONTH
    $begin_mday = 1;
    $end_mday = 28;
    $current_month = date('m');
    $current_year = date('Y');
    $temp_timestamp = "$current_year-$current_month-$begin_mday 00:00:01";
    // CALC TOTAL CASH HAS USED IN THIS MONTH
    $query = "SELECT sum(cash) AS TOTAL_CASH FROM ORDER_STORE 
    WHERE user_id = {$user_data['ID']} AND 
    exchange_status = 1 AND 
    order_date BETWEEN '$current_year-$current_month-$begin_mday 00:00:01' AND '$current_year-$current_month-$end_mday 23:59:59'
    ";
    $ajaxData->selectQuery($query);
    $total_cash_has_used_in_month = $ajaxData->_rendata[0]['TOTAL_CASH'];
    // CASH: HAS USED AND THIS ORDER
    $summary_cash_to_current = $total_cash_has_used_in_month + $sumary_cash;
?>
            <h2>Bạn đang dùng gói dịch vụ mua đồ trả theo tháng:</h2>
            <div class="bound-check-col">
                <input type="hidden" name="pay_one_time_status" value="1" />
<?php
    // MEMBER CAN ORDER MORE VIA POT SERVICE
    if( $package_price >= $summary_cash_to_current ){
?>
                <div class="check-col">
                    <div class="checkbox-container" aria-check="true">
                        <div class="checkbox"></div>
                        <div class="paper-ripple"></div>
                    </div>
                </div>
                <div class="label">
                    <p>Đã chọn thanh toán vào cuối tháng</p>
                </div>
<?php
    }else{
        $can_use_cash_in_order = $package_price - $total_cash_has_used_in_month;
        $over_can_use_in_order = $sumary_cash - $can_use_cash_in_order;
?>
    <div class="text">
<?php
        if( $can_use_cash_in_order >= 0 ){
?>
        <p>
            Tháng này bạn đã dùng: <?=number_format($total_cash_has_used_in_month, 0, ',', '.');?> / <?=number_format($package_price, 0, ',', '.');?><br>
            Đơn hàng này trị giá: <?=number_format($sumary_cash, 0, ',', '.');?> đ<br>
            Bạn chỉ có thể dùng thêm: <?=number_format($can_use_cash_in_order, 0, ',', '.');?> trong đơn hàng này khi dùng gói dịch vụ.<br>
            Khi giao hàng, chúng tôi sẽ thu khoản còn lại: <?=number_format($over_can_use_in_order, 0, ',', '.');?> đ. Và chốt gói tháng này bạn đã dùng đủ.
        </p>
        <input type="hidden" name="notice" value="Phụ thu do sử dụng vượt quá gói: <?=number_format($over_can_use_in_order, 0, ',', '.');?>" />
<?php
        }else{
?>
        <p>
            Tháng này bạn đã dùng đủ gói dịch vụ: <?=number_format($package_price, 0, ',', '.');?> đ<br>
            Khi giao hàng, chúng tôi sẽ thu tiền đơn hàng này.
        </p>
        <input type="hidden" name="notice" value="Thu tiền đơn hàng này vì đã dùng đủ tiền trong gói: <?=number_format($sumary_cash, 0, ',', '.');?>" />
<?php
        }
?>
    </div>
<?php
    }
?>
            </div>
<?php
}
?>
		    <div class="bound-action-btn">
				<button type="submit" class="_btn _btn-b __btn_order">Đặt hàng</button>
		    </div>
        </form>
	</div>

<?php
echo $empty_alert;
?>
<script data-id="_view_cart_order" nonejs>
// CHANGE LSD IN USE
$('input#use-lsd-in-order').change(function(){
	resetFinalSummaryCash();
});
function get_use_lsd(){
    var use_lsd = parseInt($('input#use-lsd-in-order').val()) > <?=$valid_lsd_for_use_in_order;?> ? <?=$valid_lsd_for_use_in_order;?> : parseInt($('input#use-lsd-in-order').val());
        use_lsd = isNaN(use_lsd) ? 0 : use_lsd;
        $('input#use-lsd-in-order').val(use_lsd);
    return use_lsd;
}
function resetFinalSummaryCash(){
	var final_summary_cash = <?=$sumary_cash;?> - get_use_lsd() * 1000;
	$('.final-summary-cash').text(final_summary_cash.format(0, 3, '.', ','));
}
resetFinalSummaryCash();
// CHANGE AMOUNT FOR ITEM
var el_input = $('input[name="order-amount-column"');
	el_input.change(function(){
		changeItemAmount(this);
	});
function changeItemAmount(t){
	var	data_add_cart = $(t).attr('data-cart'),
		amount = parseInt($(t).val()) <= 0 ? 1 : parseInt($(t).val());
		// UPDATE ATTRIBUTE: data-cart
		$(t).attr('data-cart', data_add_cart.replace(/^(id.+?amount=)([-0-9]+)/gi, '$1') + amount);
	// UPDATE BY ADDCART THEN RE-FRESH CART BY AJAX
	setTimeout(function(){
		cart_order_page.addCart(t, 'update');
	}, 0);
}
// CHECK-BOX INSIDE @.tick-all ONLY: INVOKE
EffectiveComposer.checkStatusOnElement('#order-table thead .checkbox-container .checkbox', cart_order_page.tick_all_check_box_status);
// CHECK-BOX INSIDE @.content ONLY: INVOKE
EffectiveComposer.checkStatusOnElement('#order-table tbody .checkbox-container .checkbox', cart_order_page.collection_cart_checkbox_status);
// CLEAR ITEM BY COLLECTION
$('#delete-ticked-item').click(function(){
    // CHECK ALL ITEMS IN CART INTO AN COLLECTION
    cart_order_page.collection_cart_checkbox_status();
    // CLEAR NOW!
    cart_order_page.clearCartItem(cart_order_page.showCart);
});
// ORDER FORM
var order_form = new Form_Invoke({
    containerID : 'order-table',
    formID : 'order',
    xhrURL : url_base + '/xhr/_order_store/',
    pointer_filter: {type: "container", delay: 7000},
    after_submit: {state: "success", go_to_url: url_base, delay: 6000}
}).restart({
    "content": {"value": "localStorage.getItem('cart')", "evaluate": true},
	"use_lsd": {"value": "get_use_lsd()", "evaluate": true}
});
// USING PAY ONE TIME SERVICE: BEHAVIOR
// CHECK-BOX INSIDE @.content ONLY: INVOKE
EffectiveComposer.checkStatusOnElement('form#order .checkbox-container .checkbox', change_value_pot_service_status);
function change_value_pot_service_status(el_container, status){
    $('input[name="pay_one_time_status"]').val(status);
}
</script>