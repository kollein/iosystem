<?php
// FETCH
$where = "WHERE cates_id = $curAdapter ORDER BY ord";
$cms->selectRow(CATECHILD, $where);
$rowCatechild = $cms->_rendata;
$number_item = 0;
foreach($rowCatechild as $row){
    print'
    <div class="cateChildLine" data-statement="catechild_id">
<div class="grippy"></div>
<div class="tick">
	<div class="checkbox-container" aria-check="false" data-id="'.$row['ID'].'" data-book-case="'.$BOOK_CASE.'">
        <div class="checkbox"></div>
        <div class="paper-ripple"></div>
    </div>
</div>
<div class="title"><a href="?adapter='.$curAdapter.'&catechild_id='.$row['ID'].'">'.$row['NAME'].'</a></div><div class="mDescr">'.decodeURI($row['DESCRIPTION'],0,200).'</div>
    </div>
';
	$number_item++;
}
?>