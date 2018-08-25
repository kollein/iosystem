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
	<div class="cart-title"><span>Giỏ hàng</span><span class="close"></span></div>
	<div class="cart-body">
	    <h6>Sản phẩm</h6>
	    <div class="edit-bar">
	        <div class="tick-all">
	            <div class="checkbox-container" aria-check="false">
	                <div class="checkbox"></div>
	                <div class="paper-ripple"></div>
	            </div>
	        </div>
	        <div class="info-done">
	            <span>Chọn hết</span><span>
	            <a id="clear-item-cart">Xóa</a></span>
	            <span class="number-item-cart-checked">(0)</span>
	            <span class="sumary-cash">0.00</span>
	        </div>
	    </div>
	    <div class="content body yt-scrollbar4"><div>
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
			$url_go_post = generate_url_by_map([$go_by_bookcase,$row['ID'],$urlTitle], true, true);
			$mixed_id = $go_by_bookcase.'_'.$row['ID'];
			$item_amount = $cart_data_json[$mixed_id][0]['amount'];
			$sumary_cash += $row['PRICE'] * $item_amount;
?>
<div class="item-wrapper row">
	<div class="check-col">
		<div class="checkbox-container" aria-check="false" data-id="<?=$go_by_bookcase.'_'.$row['ID'];?>">
	        <div class="checkbox"></div>
	        <div class="paper-ripple"></div>
	    </div>
	</div>
	<div class="col-d row-nw">
		<div class="cart-cover">
			<a href="<?=$url_go_post;?>">
				<img class="imgCover" src="<?=$getIMG[0];?>"/>
			</a>
		</div>
	    <div class="cart-info">
	    	<div class="title">
		    	<a href="<?=$url_go_post;?>"><?=$row['TITLE'];?></a>
		    </div>
		    <div class="price">
		    	<span><?=number_format($row['PRICE'], 0, ",", ".");?>đ</span>
		    	<span>Số lượng: <?=number_format($item_amount, 0, ",", ".");?></span>
		    </div>
		</div>
	</div>
</div>
<?php
		}
	}
}else{
	// SHOW DOT ....
	echo '....';
}
?>
		</div></div>
		<div class="order-wrapper">
	        <div class="btn-link-action" data-ripple> 
	            <button id="pending_order" class="rc-button yt-uix-button yt-uix-button-primary">Đặt Hàng</button>
	        </div>
	    </div>
	</div>
<script data-id="_view_cart_side" nonejs>
// RESET CHECK-ALL TO: FALSE
$('#cart-box .tick-all .checkbox-container').attr('aria-check', 'false');
// INSERT SOME INFO AFTER DONE
$('#cart-box .sumary-cash').html('<?=str_replace(',', '.', number_format($sumary_cash) );?> đ');
// CHECK-BOX INSIDE @.tick-all ONLY: INVOKE
EffectiveComposer.checkStatusOnElement('#cart-box .tick-all .checkbox-container .checkbox', cart_side_box.tick_all_check_box_status);
// CHECK-BOX INSIDE @.content ONLY: INVOKE EFFECTIVE
EffectiveComposer.checkStatusOnElement('#cart-box .content .checkbox-container .checkbox', cart_side_box.collection_cart_checkbox_status);
// CLEAR ITEM BY COLLECTION
$('#clear-item-cart').click(function(){
	// CHECK ALL ITEMS IN CART INTO AN COLLECTION
	cart_side_box.collection_cart_checkbox_status();
	// CLEAR NOW!
    cart_side_box.clearCartItem(cart_side_box.showCart);
    // REFRESH CART ORDER PAGE
    if( cart_order_page ){
    	cart_order_page.showCart();
    }
});
// CLOSE : HIDE CART
$('#cart-box .close').click(function(){
	$('#cart-box').removeClass('block');
});
// PENDING ORDER BEFORE GO TO: ORDER PAGE
$('#pending_order').click(function(){
	// KEY ORDER: purpose to know how many people desire click order by cart box
	var key_order = readCookie('key_order');
	var data_cart_order = {
		"key_order": key_order,
		"data_cart": cart_side_box.getDataCart()
	}
	// CHECK DATA CART
	if( Object.keys(data_cart_order['data_cart']).length > 0 ){
		$.post( url_base + '/xhr/_pending_order/', {suggest: data_cart_order} ).done(function(data){
                    if( isJsonString(data) ){
			data = JSON.parse(data);
			console.log(data);
			if( data.id ){
				console.log('Success!');
				setCookie('key_order', data.key_order, 30);
				
			}else{
				console.log(data.error);
			}
                    }
                    
	    });
            // GO ORDER
            window.location.href = '<?=generate_url_by_map([GO_ORDER]);?>';
	}else{
		console.log('Empty cart from localStorage');
	}
});
</script>