<?php
$where='ORDER BY id DESC LIMIT 64';
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
<div class="title">'.$row['TITLE'].'</div>
<div class="mDescr col-d">'.decodeURI($row['DESCRIPTION'], 0, 50).'</div>
<div class="mStatus marLeftAuto" data-tooltip="Trạng thái hiển thị hoặc ẩn">
    <div class="toggle-container" data-field="SCOPE" data-id="'.$row['ID'].'" aria-check="'.$check_status.'">
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