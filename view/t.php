<script src="<?=URLBASE;?>/js/colorist2.js"></script>
<?php
//USING ALIAS MYSQL QUERY: BOOK_TRADITIONAL -> dest, (SELECT...)-> src
$query = 'UPDATE BOOK_TRADITIONAL dest, (SELECT VIEW FROM BOOK_TRADITIONAL where id='.$curId.') src SET dest.VIEW = (src.VIEW + 1) where dest.ID='.$curId;
$mainRi->updateQuery($query);//UPDATE VIEW
// MAIN FETCH DATA WITH MULTI TABLES BY ALIAS
$query = "SELECT a.*, a.id as BOOK_ID, b.name AS CATES_NAME, c.name AS CATECHILD_NAME, d.*, d.name AS TRUSTED_SHOP_NAME, e.name AS LIST_PROVINCE_VIETNAM_NAME
FROM BOOK_TRADITIONAL AS a 
LEFT JOIN CATES AS b ON a.CATES_ID = b.ID 
LEFT JOIN CATECHILD AS c ON a.CATECHILD_ID = c.ID 
LEFT JOIN TRUSTED_SHOP AS d ON a.TRUSTED_SHOP_ID = d.ID 
LEFT JOIN LIST_PROVINCE_VIETNAM AS e ON d.LIST_PROVINCE_VIETNAM_ID = e.ID
WHERE a.ID = $curId";
$mainRi->selectQuery($query);
$rs_JOIN_row = $mainRi->_rendata[0];//result
    $getIMG_s = get_link_img_from_str($rs_JOIN_row['IMAGE']);
    $getIMG_banner = get_link_img_from_str($rs_JOIN_row['BANNER_IMAGE']);
    // PRICE: unknown or set
    $display_main_item_price = $rs_JOIN_row['PRICE'] ? number_format($rs_JOIN_row['PRICE'], 0, ',', '.').' đ' : 'Giá bằng với cửa hàng tạp hóa';
    // content: addcart
    $alias_book_case_id = "{$map_go_view[$TABLE]}_{$rs_JOIN_row['BOOK_ID']}";
    $content_order_per_item = "id=$alias_book_case_id|amount=1";
?>
<section id="show-container">
    <div class="banner-container panel">
        <div class="holder cover">
            <img class="imgCover" id=":_trusted-shop-banner" src="<?=$getIMG_banner[0];?>" onload="Image_Dominant_Color.getImageData(this.getAttribute('id'), true)"/>
            <div class="holder-content content" data-dominant-query=":_trusted-shop-banner" data-dominant-set-type="background">
                <div class="name"><?=$rs_JOIN_row['TRUSTED_SHOP_NAME'];?></div>
                <div class="info-wrapper wrapper">
                    <ul>
                        <li>
                            <span class="icon _address"></span>
                            <span class="text"><?=$rs_JOIN_row['ADDRESS'];?> (<?=$rs_JOIN_row['LIST_PROVINCE_VIETNAM_NAME'];?>)</span>
                        </li>
                        <li>
                            <span class="icon _mobile"></span>
                            <span class="text"><?=$rs_JOIN_row['PHONE_NUMBER'];?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="block-container">
        <div class="row">
            <div class="store-content col-d10064">
<div class="image-store-swiper">
    <div class="swiper-container">
        <div class="swiper-wrapper">
<?php
foreach($getIMG_s as $img){
?>
            <div class="swiper-slide">
                <div class="_cover"><img class="imgScaledown" src="<?=$img;?>"/></div>
            </div>
<?php
}
?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
<div class="content-store-wrapper ui-wrapper yt-card">
    <div class="row">
        <div class="col-d">
            <div class="_title">
                <h1><?=$rs_JOIN_row['TITLE'];?></h1>
            </div>
            <div class="_price">
                <?=$display_main_item_price;?>
            </div>
        </div>
        <div class="bound-addcart">
            <button class="btn _btn _btn-o" data-tooltip="Gọi: <?=HOTLINE;?>" data-ripple>
                <a href="tel:<?=HOTLINE;?>">
                    <span class="icon telephone"></span>
                </a>
            </button>
            <button class="btn _btn _btn-b __btn_add_cart" data-cart="<?=$content_order_per_item;?>" data-tooltip="Thêm vào giỏ hàng" data-ripple>
                <span class="icon cart"></span>
            </button>
        </div>
    </div>
    <div class="bound-view">
        <div class="_view">
            <div class="countView">
                <?=number_format($rs_JOIN_row['VIEW']);?> quan tâm
            </div>
        </div>
    </div>
</div>
<div class="desc-store-wrapper ui-wrapper yt-card">
    <div class="dot-line"></div>
    <div class="_desc"><?=decodeURI($rs_JOIN_row['DESCRIPTION'], 0, 0);?></div>
</div>
        </div>
        <div class="store-sidebar col-d10036">
            <div class="ui-wrapper yt-card">
<div id="order-store" class="order-store-wrapper">
    <div class="_title">
        <div class="headerTitle">Đặt Hàng Nhanh</div>
        <span class="noticeTitle">Vui lòng nhập thông tin chính xác</span>
    </div>
    <form id="quick_order" class="form-submit">
        <div class="error-text"></div>
        <input type="hidden" name="content" value="<?=$content_order_per_item;?>"/>
        <div class="bound-form-control">
            <input class="form-control" data-require="1" type="text" name="user_name"/>
            <label class="label-place-top">
                <span class="label-title">Tên của bạn</span>
            </label>
        </div>
        <div class="bound-form-control">
            <input class="form-control" data-require="1" type="text" name="phone_number"/>
            <label class="label-place-top">
                <span class="label-title">Số điện thoại</span>
            </label>
        </div>
        <div class="bound-form-control">
            <input class="form-control" data-require="1" type="text" name="address"/>
            <label class="label-place-top">
                <span class="label-title">Địa chỉ của bạn <span class="m-desc">(vd: 46 Tran Hung Dao, Quan 1, HCM)</span></span>
            </label>
        </div>
        <div class="action-box">
            <button type="submit" class="_order_btn _btn _btn-b" data-ripple>Order</button>
        </div>
    </form>
</div>
            </div>
            <div class="ui-wrapper yt-card">
<?php
$you_need_know = 't_adapter';
include 'stack/you_need_know.php';
?>
            </div>
            <div class="ui-wrapper yt-card">
<div class="related-store-wrapper">
<?php
$where = "WHERE id != $curId AND catechild_id = {$rs_JOIN_row['CATECHILD_ID']} ORDER BY view DESC LIMIT 100";
$mainRi->selectRow(BOOK_TRADITIONAL, $where);
$rowBOOK_TRADITIONAL_s = $mainRi->_rendata;
foreach( $rowBOOK_TRADITIONAL_s as $row ){
    $urlTitle = convertAlias($row['TITLE'], true);
    $url_GO_STORE = generate_url_by_map([$map_go_view[BOOK_TRADITIONAL], $row['ID'], $urlTitle], true, true);
    $getIMG = get_link_img_from_str($row['IMAGE']);
?>
    <div class="_item row">
        <div class="coverImg col-d104">
            <a class="title" href="<?=$url_GO_STORE;?>">
                <img class="imgCover" src="<?=$getIMG[0];?>"/>
            </a>
        </div>
        <div class="titleWrapper col-d106">
            <a class="title" href="<?=$url_GO_STORE;?>"><?=$row['TITLE'];?></a>
            <div class="price"><?=number_format($row['PRICE'], 0, ',', '.');?> đ</div>
            <div class="view"><?=number_format($row['VIEW']);?> quan tâm</div>
        </div>
    </div>
<?php
}
?>
</div>
            </div>
            </div>
        </div>
    </div>
</section>
<script>
// SWIPER PLUGIN: CONFIG
var swiper = new Swiper('.swiper-container', {
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    pagination: '.swiper-pagination',
    paginationType: 'progress'
});
// FORM INVOKE: QUICK ORDER
var quick_order = new Form_Invoke({
    containerID : 'order-store',
    formID : 'quick_order',
    xhrURL : url_base + '/xhr/_order_store/'
}).restart();
// SET CACHE HISTORY: view_item_history
cache_history.set_cache_history('view_item_history', '<?=$alias_book_case_id;?>');
</script>