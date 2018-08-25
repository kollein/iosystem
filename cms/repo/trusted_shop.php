<?php
$where='ORDER BY id DESC LIMIT 0, 50';
$cms->selectRow($TABLE, $where);
$rowOrder = $cms->_rendata;
$number_item = 0;
foreach($rowOrder as $row){
    $check_status = $row['STATUS'] == 1 ? 'true' : 'false';
    print'
    <div class="cateChildLine">
<div class="grippy"></div>
<div class="tick">
	<div class="checkbox-container" aria-check="false" data-id="'.$row['ID'].'" data-book-case="'.$BOOK_CASE.'">
        <div class="checkbox"></div>
        <div class="paper-ripple"></div>
    </div>
</div>
<div class="title">'.$row['NAME'].'</div>
<div class="mDescr col-d">'.$row['CONTENT'].'</div>
<div class="mStatus marLeftAuto" data-tooltip="Order status (read or un-read)">
    <div class="toggle-container" data-field="STATUS" data-id="'.$row['ID'].'" aria-check="'.$check_status.'">
        <div class="toggleBar">
            <div class="circle">
                <div class="paper-ripple"></div>
            </div>
        </div>
    </div>
</div>
    </div>
';
	$number_item++;
}
?>