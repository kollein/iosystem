<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

// JSON from POST AJAX
$content = $_POST['suggest'];
if( $content['id'] ){
//call Class by Magic
$ajaxData = new Adapter_order($conn);
$where = "WHERE id = {$content['id']}";
$ajaxData->selectRow(ORDER_STORE, $where);
$rowORDER_STORE = $ajaxData->_rendata[0];
// EXCHANGE
if( $rowORDER_STORE['EXCHANGE_STATUS'] == 1 ){
    $exchange_status_alert = 'Giao dịch thành công.';
    $exchange_status_color = 'success';
}else{
    $exchange_status_alert = 'Đang chờ giao dịch';
    $exchange_status_color = 'failed';
}
// USE LSD
$use_lsd = $rowORDER_STORE['USE_LSD'] + 0;
// GET USER DATA
$user_data = $ajaxData->getUserWithHash();
?>

    <div class="order-container content-container">
        <div class="heading">Đơn hàng: <?=formatDateFromTimestamp('d-m-Y H:i:s', $rowORDER_STORE['ORDER_DATE']);?></div>
        <div class="exchange">
            <span class="code"><span class="_label">Mã số giao dịch: </span><span class="_content"><?=$rowORDER_STORE['ID'];?></span></span>
            <span class="status"><span class="_label">Tình trạng: </span><span class="_content <?=$exchange_status_color;?>"><?=$exchange_status_alert;?></span></span>
        </div>
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
$cart_data_json = json_decode($rowORDER_STORE['CONTENT'], true);
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
        <a href="<?=$url_go_post;?>">
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
<tr class="summary-line">
    <td>&nbsp;</td>
    <td><div class="inline">Tổng cộng:</div></td>
    <td><div class="inline">&nbsp;</div></td>
    <td><div class="inline">&nbsp;</div></td>
    <td><div class="inline">&nbsp;</div></td>
    <td><div class="inline"><?=number_format($sumary_cash, 0, ',', '.');?></div></td>
</tr>
<tr class="summary-line">
    <td>&nbsp;</td>
    <td><div class="inline">Sử dụng tiền tiết kiệm <a href="<?=generate_url_by_map([GO_HELP, HELP_FAQ, '?question=1']);?>">[?]</a></div></td>
    <td><div class="inline">&nbsp;</div></td>
    <td><div class="inline"><?=number_format($use_lsd, 0, ',', '.');?></div></td>
    <td><div class="inline">còn lại:</div></td>
    <td><div class="inline"><?=number_format($sumary_cash - ($use_lsd * 1000), 0, ',', '.');?></div></td>
</tr>
        </tbody>
    </table>
        </div>
    </div>
<?php
}else{
    echo 'Không có dữ liệu cho đơn hàng này';
}
?>