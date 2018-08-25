<?php
// CHECK TO QUERY MYSQL
if( $curCatechildid ){
    $where = "WHERE catechild_id = $curCatechildid";
}else{
    $where = "WHERE cates_id = $curAdapter";
}
$where .= " ORDER BY id DESC";
$cms->selectRow($TABLE, $where);
$rowBOOK_s = $cms->_rendata;
$number_item = 0;
foreach( $rowBOOK_s as $row ){
    $check_status = $row['STATUS'] == 1 ? 'true' : 'false';
    $check_order_status = $row['ORDER_STATUS'] == 1 ? 'true' : 'false';
    $check_hot_status = $row['HOT_STATUS'] == 1 ? 'true' : 'false';
    // 
    $alias_book_case_table = $map_go_view[$TABLE];
	$urlTitle = convertAlias($row['TITLE'], true);
	$url_go_post = generate_url_by_map([$alias_book_case_table, $row['ID'], $urlTitle], true, true);
    print'
    <div class="cateChildLine" data-statement="postid">
<div class="grippy"></div>
<div class="tick">
    <div class="checkbox-container" aria-check="false" data-id="'.$row['ID'].'" data-book-case="'.$BOOK_CASE.'">
        <div class="checkbox"></div>
        <div class="paper-ripple"></div>
    </div>
</div>
<div class="title"><a target="_blank" href="'.$url_go_post.'">'.$row['TITLE'].'</a></div>
<div class="mDescr">'. $row['TAG'] .'</div>
<div class="mStatus marLeftAuto" data-tooltip="Tình trạng sản phẩm đang hot">
    <div class="toggle-container" data-field="HOT_STATUS" data-id="'.$row['ID'].'" aria-check="'.$check_hot_status.'">
        <div class="toggleBar red">
            <div class="circle">
                <div class="paper-ripple"></div>
            </div>
        </div>
    </div>
</div>
<div class="mStatus" data-tooltip="Tình trạng còn hoặc hết hàng">
    <div class="toggle-container" data-field="ORDER_STATUS" data-id="'.$row['ID'].'" aria-check="'.$check_order_status.'">
        <div class="toggleBar green">
            <div class="circle">
                <div class="paper-ripple"></div>
            </div>
        </div>
    </div>
</div>
<div class="mStatus" data-tooltip="Tình trạng hiển thị hoặc ẩn">
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
/**CACHED TO SHOW AT: @template.php
-- $number_item
**/
?>