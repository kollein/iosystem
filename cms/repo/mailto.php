<?php
$where='ORDER BY id DESC LIMIT 0, 50';
$cms->selectRow(MAILTO,$where);
$rowMailto=$cms->_rendata;

foreach($rowMailto as $row){
    print'
    <div class="cateChildLine">
<div class="grippy"></div>
<div class="tick"><input id="'.$row['ID'].'" type="checkbox"/></div>
<div class="title"><a target="_blank" href="http://www.likeart.vn/module/mail.php?id='.$row['ID'].'&recipient='.$row['RECIPIENT'].'">'.$row['SUBJECT'].'</a></div>
<div class="mDescr">'.decodeURI($row['DESCRIPTION'],0,200).'</div>
    </div>
';
}
?>