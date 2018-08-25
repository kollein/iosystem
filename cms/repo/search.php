<?php
$key = $_GET['q'];
if( $key ){
    $where = 'WHERE title LIKE "%'.$key.'%"';
    $query = "SELECT p.ID, p.TITLE, p.DESCRIPTION, if (p.TIMESTAMP = 0, 'PRODUCT', 'PRODUCT') AS 'BOOK_CASE' FROM BOOK_PRODUCT AS p {$where}
    UNION ALL
    SELECT i.ID, i.TITLE, i.DESCRIPTION, if (i.TIMESTAMP = 0, 'INFO', 'INFO') AS 'BOOK_CASE' FROM BOOK_INFO AS i {$where}";
$cms->selectQuery($query);
$rowBOOK_s = $cms->_rendata;
$number_item = 0;
foreach( $rowBOOK_s as $row ){
    $check_status = ($row['STATUS'] > 0) ? 'false' : 'true';
    $check_order_status = ($row['ORDER_STATUS'] > 0) ? 'false' : 'true';
    $urlTitle = convertAlias($row['TITLE'],true);
    print'
    <div class="cateChildLine" data-statement="postid">
<div class="grippy"></div>
<div class="tick">
    <div class="checkbox-container" aria-check="false" data-id="'.$row['ID'].'" data-book-case="'.$row['BOOK_CASE'].'">
        <div class="checkbox"></div>
        <div class="paper-ripple"></div>
    </div>
</div>
<div class="title"><a target="_blank" href="">'.$row['TITLE'].'</a></div>
<div class="mDescr">'.decodeURI($row['DESCRIPTION'], 0, 200).'</div>
<div class="mStatus marLeftAuto" data-tooltip="Item status (hide or show)">
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

}
?>