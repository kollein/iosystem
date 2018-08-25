<?php
//call Class by Magic
$orderData = new Adapter_order($conn);
// CALC SUMMARY LSD GOT
$has_got_lsd = $orderData->calc_summary_lsd_got_by_all_exchange_order($user_data['ID'], 1);
$has_used_lsd = $orderData->calc_summary_lsd_used_by_all_exchange_order($user_data['ID'], false);
$valid_lsd_for_use_in_order = $has_got_lsd - $has_used_lsd;
?>
<div class="content-profile">
    <div class="notice-box ui-wrapper cr-card">
        <h2>Điểm thưởng là gì?</h2>
        <p>Khi mua hàng hóa trên Website bạn sẽ có được điểm thưởng dựa vào số tiền bạn đã mua.</p>
        <p>VD: 10 ngàn đồng (1 hóa đơn mua hàng): Bạn sẽ được 1 điểm thưởng.</p>
        <p>1 điểm (1 LSD) = 1 ngàn đồng.</p><br>
        <p><i>Tiền thưởng này bạn có thể dùng để mua hàng hóa trên Website.</i></p><br>
        <p>Nếu hóa đơn vượt quá 50 ngàn đồng, Tiền thưởng sẽ được tính như sau:</p>
        <p>VD: 200 ngàn đồng (1 hóa đơn) = 5 + ( 200 x 3 ÷ 100 ) = 11 ngàn đồng.</p>
        <p>Tiền này là tiền tiết kiệm của bạn.</p>
    </div>
    <h2 class="title">Điểm thưởng hiện có</h2>
    <div class="ui-wrapper cr-card">
        <table class="lsd-table summary">
            <thead>
                <tr>
                    <td class="title"><div class="inline">Tổng số hiện có:</div></td>
                    <td class="text-lsd"><div class="inline"><?=number_format($valid_lsd_for_use_in_order, 0, ',', '.');?></div></td>
                    <td class="icon"><div class="inline"><div class="_icon lsd-icon"></div></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="title"><div class="inline">Tổng đã dùng:</div></td>
                    <td class="text-lsd"><div class="inline"><?=number_format($has_used_lsd, 0, ',', '.');?></div></td>
                    <td class="icon"><div class="inline"><div class="_icon lsd-icon"></div></td>
                </tr>
                <tr>
                    <td class="title"><div class="inline">Tổng tiết kiệm được:</div></td>
                    <td class="text-lsd"><div class="inline"><?=number_format($has_got_lsd, 0, ',', '.');?></div></td>
                    <td class="icon"><div class="inline"><div class="_icon lsd-icon"></div></td>
                </tr>
            </tbody>
        </table>
    </div>
    <h2 class="title">Lịch sử điểm thưởng</h2>
    <div class="ui-wrapper cr-card">
        <table id="lsd-table-history" class="lsd-table history">
            <thead>
                <tr>
                    <td class="exchange-status"><div class="inline">TT</div></td>
                    <td class="code"><div class="inline">Mã số giao dịch</div></td>
                    <td class="c-lsd"><div class="inline">Đã dùng LSD</div></td>
                    <td class="c-lsd"><div class="inline">Thưởng LSD</div></td>
                    <td class="date"><div class="inline">Vào lúc</div></td>
                </tr>
            </thead>
            <tbody>
<?php
// FETCH ALL ORDER HAS EXCHANGED SUCCESS 
$where = "WHERE user_id = {$user_data['ID']} ORDER BY id DESC LIMIT 50";
$mainRi->selectRow(ORDER_STORE, $where);
$rowORDER_STORE_s = $mainRi->_rendata;
if( $rowORDER_STORE_s ){
    foreach( $rowORDER_STORE_s as $row ){

        // FORMAT ORDER DATE
        $order_date = formatDateFromTimestamp('d-m-Y H:i:s', $row['ORDER_DATE']);
        // CHECK EXCHANGE STATUS
        if( $row['EXCHANGE_STATUS'] ){
            $type_shape = 'success';
            $data_tooltip = 'Giao dịch thành công';
        }else{
            $type_shape = 'waiting';
            $data_tooltip = 'Đang chờ giao dịch';
        }
?>
<tr data-id="<?=$row['ID'];?>">
    <td class="exchange-status">
        <div class="inline">
            <div class="_icon ui-sign-shape" data-tooltip="<?=$data_tooltip;?>">
                <div class="square-16 <?=$type_shape;?>"></div>
            </div>
        </div>
    </td>
    <td class="code"><div class="inline"><?=$row['ID'];?></div></td>
    <td class="c-lsd"><div class="inline">-<?=number_format($row['USE_LSD'], 0, ',', '.');?></div></td>
    <td class="c-lsd"><div class="inline">+<?=number_format($row['GET_LSD'], 0, ',', '.');?></div></td>
    <td class="date"><div class="inline"><?=$order_date;?></div></td>
</tr>
<?php
    }
}else{
?>
    <tr>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
        <td>...</td>
    </tr>
<?php
}
?>
            </tbody>
        </table>
    </div>
</div>
<script>
var tr_recent_order_popup = new Popup_Invoke({
    containerID: 'lsd-table-history',
    iterators: 'table#lsd-table-history tbody tr',
    xhrURL: url_base + '/xhr/_view_recent_order/',
}).restart();
</script>