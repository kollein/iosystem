<?php
if( !$curId ){
    //Stop Excecutes Processors Below
    exit;
}
?>
<?php
//USING ALIAS MYSQL QUERY: BOOK_INFO -> dest, SELECT...-> src
//Notice: timestamp will also UPDATED
$query = 'UPDATE BOOK_INFO dest, (SELECT VIEW FROM BOOK_INFO where id='.$curId.') src SET dest.VIEW = (src.VIEW + 1) where dest.ID='.$curId;
$mainRi->updateQuery($query);//UPDATE VIEW
?>
<section id="show-container" class="block-container">
    <div class="row">
<?php
$query = "SELECT a.*, c.name AS CATES_NAME, b.name AS CATECHILD_NAME 
FROM BOOK_INFO AS a LEFT JOIN CATES AS c ON a.CATES_ID = c.ID 
LEFT JOIN CATECHILD AS b ON a.CATECHILD_ID = b.ID 
WHERE a.ID = $curId";
$mainRi->selectQuery($query);
$rs_JOIN_row = $mainRi->_rendata[0];//result
    $getIMG_s = get_link_img_from_dom($rs_JOIN_row['DESCRIPTION'], true);
    //CONTENT: de nap vao database khi order
    $content_order_store = "{'$curAdapterOrigin':{$rs_JOIN_row['ID']}}";
?>
        <div class="store-content col-d107">
<div class="content-store-wrapper ui-wrapper yt-card">
    <div class="_title">
        <h1 class="info"><?=$rs_JOIN_row['TITLE'];?></h1>
    </div>
    <div class="_author">
        <span>Tác giả: <?=$rs_JOIN_row['AUTHOR'];?></span>
    </div>
    <div class="_view">
        <div class="countView">
            <?=number_format($rs_JOIN_row['VIEW']);?> lượt xem
        </div>
    </div>
</div>
<div class="desc-store-wrapper ui-wrapper yt-card">
    <div class="dot-line"></div>
    <div class="_desc"><?=decodeURI($rs_JOIN_row['DESCRIPTION'], 0, 0);?></div>
</div>
        </div>
        <div class="store-sidebar col-d103">
            <div class="ui-wrapper yt-card">
<div class="order-store-wrapper">
    <div class="_title">
        <div class="headerTitle">Nhận thông tin về mục này</div>
        <span class="noticeTitle">Vui lòng nhập thông tin chính xác</span>
    </div>
    <form id="order_store">
        <input type="hidden" name="content" value="<?=$content_order_store;?>"/>
        <div class="bound-form-control">
            <input class="form-control" type="text" name="email"/>
            <label class="label-place-top">
                <span class="label-title">Email của bạn</span>
            </label>
        </div>
        <button type="submit" class="_order_btn _btn _btn-b" data-ripple>Hoàn tất</button>
    </form>
</div>
            </div>
            <div class="ui-wrapper yt-card">
<div class="terms-store-wrapper">
    <div class="_title">Bạn cần biết?</div>
    <div class="_content">
        <ul>
            <li>Thông tin bạn xem trên website đã được xét duyệt kỹ</li>
            <li>Khi thấy có gì sai xót hãy liên hệ cho chúng tôi!</li>
        </ul>
    </div>
</div>
            </div>
            <div class="ui-wrapper yt-card">
<div class="related-store-wrapper">
<?php
$where = "WHERE id != $curId AND catechild_id = {$rs_JOIN_row['CATECHILD_ID']} ORDER BY view DESC LIMIT 12";
$mainRi->selectRow(BOOK_INFO, $where);
$rowBOOK_INFO_s = $mainRi->_rendata;
foreach( $rowBOOK_INFO_s as $row ){
    $urlTitle = convertAlias($row['TITLE'], true);
    $url_GO_STORE = URLBASE.'/'.$map_go_view[BOOK_INFO].'/'.$row['ID'].'/'.$urlTitle.HTML_EXT;
    $getIMG = get_link_img_from_dom($row['DESCRIPTION'], true);
    //STATUS: con ve hoac het ve
    $row['TEXT_STATUS'] = !$rs_JOIN_row['ORDER_STATUS'] ? 'Vẫn còn vé' : 'Đã hết vé';
?>
    <div class="_item row">
        <div class="coverImg col-d104">
            <a class="title" href="<?=$url_GO_STORE;?>">
                <img class="imgCover" src="<?=$getIMG[0];?>"/>
            </a>
        </div>
        <div class="titleWrapper col-d106">
            <a class="title" href="<?=$url_GO_STORE;?>"><?=$row['TITLE'];?></a>
            <div class="orderStatus"><?=$row['TEXT_STATUS'];?></div>
            <div class="view"><?=number_format($row['VIEW']);?> lượt xem</div>
        </div>
    </div>
<?php
}
?>
</div>
            </div>
        </div>
    </div>
</section>
<?php
$footer_map_force_script['check_form_control'] = true;
?>