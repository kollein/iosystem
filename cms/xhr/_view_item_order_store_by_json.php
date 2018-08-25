<?php
include '../../config.php';
include '../../function.php';
include '../../autoload.php';

// JSON from POST AJAX
$content = $_POST['suggest'];
if( $content ){
    //call Class by Magic
    $ajaxData = new Adapter_order($conn);
?>

    <div class="order-container">
        <div class="content-wrapper">
    <table cellpadding="0">
        <thead>
<tr>
    <td class="checkall"></td>
    <td class="title"><div class="inline">Tên sản phẩm</div></td>
    <td class="image"><div class="inline">Ảnh</div></td>
    <td class="price"><div class="inline">Giá</div></td>
    <td class="amount"><div class="inline">Số lượng</div></td>
    <td class="summary"><div class="inline">Tổng</div></td>
</tr>
        </thead>
        <tbody class="body">
<?php
// ASSIGN @$cart_data_json
$cart_data_json = json_decode($content, true);
// REVERSE TO SEE LAST ADDED AT TOP
$cart_data_json = is_array($cart_data_json) ? array_reverse($cart_data_json) : $cart_data_json;
// CHECK : @cart_data_json MUST IS ARRAY
if ( is_array($cart_data_json) ){
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
            $summary_line = $row['PRICE'] * $item_amount;
            $sumary_cash += $row['PRICE'] * $item_amount;
?>
<tr>
    <td></td>
    <td><div class="inline"><?=$row['TITLE'];?></div></td>
    <td>
        <a target="_blank" href="<?=$url_go_post;?>">
            <div class="cover">
                <img class="imgScaledown" src="<?=$getIMG[0];?>"/>
            </div>
        </a>
    </td>
    <td><div class="inline"><?=number_format($row['PRICE'], 0, ",", ".");?></div></td>
    <td><div class="inline"><?=$item_amount;?></div></td>
    <td><div class="inline"><?=number_format($summary_line, 0, ",", ".");?></div></td>
</tr>
<?php
        }
    }
}else{
?>
<tr>
	<td>....</td>
</tr>
<?php
}
?>
        </tbody>
    </table>
        </div>
    </div>
<?php
}else{
    echo 'Không có dữ liệu cho đơn hàng này';
}
?>