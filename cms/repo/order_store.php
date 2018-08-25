<?php
$where='ORDER BY id DESC LIMIT 0, 50';
$cms->selectRow($TABLE, $where);
$rowOrder = $cms->_rendata;
$number_item = 0;
foreach($rowOrder as $row){
    $check_status = $row['STATUS'] == 1 ? 'true' : 'false';
    if( $row['EXCHANGE_STATUS'] == 1 ){
        $check_exchange_status = 'true';
        $text_exchange_status = 'Đã giao dịch';
    }else{
        $check_exchange_status = 'false';
        $text_exchange_status = 'Đang chờ giao dịch';
    }
    $highlight = $row['STATUS'] == 1 ? 'read' : 'unread';
    $rowTitle = $row['USER_ID'] ? 'USER_ID: '.$row['USER_ID'] : ($row['USER_NAME'] ? $row['USER_NAME'] : $row['PHONE_NUMBER']);
?>
    <div class="cateChildLine">
<div class="grippy"></div>
<div class="tick">
	<div class="checkbox-container" aria-check="false" data-id="<?=$row['ID'];?>" data-book-case="<?=$BOOK_CASE;?>">
        <div class="checkbox"></div>
        <div class="paper-ripple"></div>
    </div>
</div>
<div class="title <?=$highlight;?>"><?=$rowTitle;?></div>
<div class="mDescr col-d"><?=$row['CONTENT'];?></div>
<div class="mStatus marLeftAuto" data-tooltip="<?=$text_exchange_status;?>">
    <div class="toggle-container" data-field="EXCHANGE_STATUS" data-id="<?=$row['ID'];?>" aria-check="<?=$check_exchange_status;?>">
        <div class="toggleBar green">
            <div class="circle">
                <div class="paper-ripple"></div>
            </div>
        </div>
    </div>
</div>
<div class="mStatus marLeftAuto" data-tooltip="Đã được xem qua hay chưa">
    <div class="toggle-container" data-field="STATUS" data-id="<?=$row['ID'];?>" aria-check="<?=$check_status;?>">
        <div class="toggleBar">
            <div class="circle">
                <div class="paper-ripple"></div>
            </div>
        </div>
    </div>
</div>
    </div>
<?php
	$number_item++;
}
?>