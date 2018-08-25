        <div class="pie-list-box noPad fullWidth">
            <h2>Giỏ hàng của bạn:</h2>
            <div class="market-box pie-box">
                <div class="pie-snap">
                    <ul class="listdeal-four row">
<?php
include '../../config.php';
include '../../function.php';
$content = array_reverse(json_decode($_POST['suggest'], true), true);

//call Class by Magic
include '../../autoload.php';

$mainRi = new Model_sqlDynamic($conn, $content, 0);
if($content){
    $sumCash = 0;

    foreach($content as $id => $arr){$i++;

    $id = str_replace('_','',$id);
    $where = 'WHERE id='.$id;
    $mainRi->selectRow(BOOKS, $where);
    $row = $mainRi->_rendata[0];

    $getIMG = get_link_img_from_dom($row['DESCRIPTION'],true);
	$urlCatename = convertAlias($row['NAME'],true);
	$urlTitle = convertAlias($row['TITLE'],true);
	$urlGoPOST = URLBASE.'/'.GOPOST.'/'.$urlTitle.'-'.$row['CATES_ID'].'-'.$row['ID'].HTML_EXT;

    $PRICE = round($row['PRICE'] - ($row['PRICE'] * $row['SALE'] / 100));
    $PRICEOUT = $arr[0]['amount'] * $PRICE;
    $sumCash += $PRICEOUT;

    $dataItemForAddCart = "id=".$row['ID']."|image=".$getIMG[0]."|title=".$row['TITLE']."|price=".number_format($PRICE)."";
?>
<li class="cm-card">
    <a href="<?=$urlGoPOST;?>"><img src="<?=$getIMG[0];?>"/></a>
    <div class="listdeal-info <?=$displayClass;?>">
        <h3 class="m-name"><?=$row['TITLE'];?></h3>
        <div class="listdeal-group">
            <p class="listdeal-info-L" style="width: 36%;"><label class="amount">SL</label><input type="number" class="amount action-change-amount" data-item="<?=$dataItemForAddCart;?>" value="<?=$arr[0]['amount'];?>" min="1"/></p>
            <p class="listdeal-info-Lcg" style="width: 40%;">
                <span class="trueprice"><?=number_format($row['PRICE']);?>đ</span>
                <span class="price"><?=number_format($PRICE);?>đ</span>
            </p>
            <p class="listdeal-info-Rcg" style="width: 20%;">
                <a class="order_clear_item_cart" data-itemId="<?=$id;?>">Xóa</a>
            </p>
        </div>
    </div>
</li>
<?php
    }
}else{
?>
    <p>Không có sản phẩm nào trong giỏ hàng!</p>
<?php
}
?>
                    </ul>
                </div>
            </div>
<div class="infoOrderCart">
    <p class="sum-cash">Tổng cộng: <?=number_format($sumCash);?>đ</p>
</div>
        </div>
<script>
//ADD CART
$('.action-change-amount').change(function(){
    var dataItem = $(this).attr('data-item');
    var amount = $(this).val();
    addCart(dataItem, amount, true);
    loadCart();
});
$('.order_clear_item_cart').click(function(){
    clearCartItem($(this).attr('data-itemId'));
    loadCart();
});
</script>