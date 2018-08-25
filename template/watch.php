<?php
class Template_watch extends Model_Resource_config_data{

	public $itemId;
	public $rowItem;
    public $alias_book_case_id;

	function __construct(){

        // CACHE
        parent::__construct();
		// GLOBAL
        global $curId;
		// CACHE
		$this->itemId = $curId;
		// PROCCESS
        $this->update_item_view_plus_one();
        $this->fetch_item();
	}

	// UPDATE VIEW +1
	function update_item_view_plus_one(){

		//USING ALIAS MYSQL QUERY: BOOK_ -> dest, (SELECT...)-> src
		$query = "UPDATE $this->TABLE dest, (SELECT VIEW FROM $this->TABLE where id = $this->itemId) src SET dest.VIEW = (src.VIEW + 1) where dest.ID = $this->itemId";
		$this->mainRi->updateQuery($query);
	}

	// FETCH ITEM
	function fetch_item(){

		$query = $this->make_main_query();
		$this->mainRi->selectQuery($query);
        // CACHE
		$this->rowItem = $this->mainRi->_rendata[0];
		// ASSIGN
		$getIMG_banner = get_link_img_from_str($this->rowItem['BANNER_IMAGE']);
		
	}

	// HEADER
	function header_html(){
?>
		<section id="show-container">
<?php
	}
	function close_header_html(){
?>
		</section>
<?php
	}

	// BLOCK CONTAINER
	function main_block_html(){

        // ASSIGN
		$getIMG_s = get_link_img_from_str($this->rowItem['IMAGE']);
		// PRICE
		$display_main_item_price = $this->rowItem['PRICE'] ? number_format($this->rowItem['PRICE'], 0, ',', '.').' đ' : 'Giá bằng với cửa hàng tạp hóa';
		$book_case_alias = $this->map_go_view[$this->TABLE];
		$alias_book_case_id = "{$book_case_alias}_{$this->rowItem['BOOK_ID']}";
        // CACHE
        $this->alias_book_case_id = $alias_book_case_id;
		// CONTENT: ADDCART
		$content_order_per_item = "id=$alias_book_case_id|amount=1";
        // URL
        $urlCates = convertAlias($this->rowItem['CATES_NAME'], true);
        $urlCatechild = convertAlias($this->rowItem['CATECHILD_NAME'], true);
        $url_go_cates = generate_url_by_map([$urlCates]);
        $url_go_catechild = generate_url_by_map([$urlCates, $urlCatechild]);
?>
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
                <div class="cover tile" data-scale="2.5"><img class="photo imgScaledown" src="<?=$img;?>"/></div>
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
            <div class="title">
                <h1><?=$this->rowItem['TITLE'];?></h1>
            </div>
            <div class="price">
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
        <div class="view">
            <div class="countView">
                <?=number_format($this->rowItem['VIEW']);?> quan tâm
            </div>
        </div>
    </div>
</div>
<div class="desc-store-wrapper ui-wrapper yt-card">
    <div class="dot-line"></div>
    <div class="watch-time-text"><?=date_diff_text_ago($this->rowItem['TIMESTAMP']);?></div>
    <div class="watch-description-html"><?=decodeURI($this->rowItem['DESCRIPTION'], 0, 0);?></div>
    <div class="watch-description-extras">
        <ul class="watch-extras-section">
            <li>
                <h4>Danh mục</h4>
                <ul class="watch-info-tag-list">
                    <li><a href="<?=$url_go_cates;?>"><?=$this->rowItem['CATES_NAME'];?></a></li>
                    <li> <span>></span> <a href="<?=$url_go_catechild;?>"><?=$this->rowItem['CATECHILD_NAME'];?></a></li>
                </ul>
            </li>
        </ul>
    </div>
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
$you_need_know_alias = $book_case_alias;
include 'view/stack/you_need_know.php';
?>
            </div>
            <div class="ui-wrapper yt-card">
                <div class="related-store-wrapper">
<?php
// INIT: CONSTRUCTOR TEMPLATE GRID
$tpl_related_watch = new Template_related_watch();
// CHECK USER HAS LOGIN OR NO
if( $this->user_data['HASH'] ){
    $tpl_gdata = new Model_Cache_gdata($this->mainRi); 
    $id_collection_str = $tpl_gdata->collect_id_item_from_user_cache_by_book_case_alias($this->user_data['ID'], $book_case_alias, 4);
    // MAKE QUERY : UNION
    $query_recomended = "SELECT * FROM {$this->TABLE} WHERE cates_id = {$this->rowItem['CATES_ID']} AND id IN ($id_collection_str) AND id != $this->itemId UNION ";
}else{
    $query_recomended = '';
}

// NEWEST BOOK: USE @temp FOR PURPOSE: SORT DESC 
$query_newest = "SELECT * FROM {$this->TABLE} WHERE id IN ( SELECT id FROM (SELECT id FROM {$this->TABLE} WHERE cates_id = {$this->rowItem['CATES_ID']} ORDER BY id DESC LIMIT 0, {$this->map_limit_book['GRIDBLOCK_CATES_NEWEST']}) as temp ) AND id != $this->itemId";
$query = $query_recomended.$query_newest;
$location = $book_case_alias ."_page";
$suggest = 'recomended|'. $this->rowItem['CATES_ID'] .'|'. $this->rowItem['CATECHILD_ID'];
// SHOW
$tpl_related_watch->item($query, 'ĐỀ XUẤT CHO BẠN', $location, false, $suggest);
?>
                </div>
            </div>
            </div>
        </div>
    </div>
<?php
	}

	// SWIPPER SCRIPT
	function footer_js(){
?>
		<script>
		// SWIPER PLUGIN: CONFIG
		var swiper = new Swiper('.swiper-container', {
		    nextButton: '.swiper-button-next',
		    prevButton: '.swiper-button-prev',
		    pagination: '.swiper-pagination',
		    paginationType: 'progress'
		});

        // HOVER ZOOM
        $('.tile')
            // tile mouse actions
            .on('mouseover', function(){
              $(this).children('.photo').css({'transform': 'scale('+ $(this).attr('data-scale') +')'});
            })
            .on('mouseout', function(){
              $(this).children('.photo').css({transform: 'scale(1)'});
            })
            .on('mousemove', function(e){
              $(this).children('.photo').css({'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 +'%'});
            })
            // tiles set up
            .each(function(){
              $(this)
                // add a photo container
                .append('<div class="photo"></div>');
            });

        // CLICK ZOOM : HIEN TAI KHONG DUNG NUA
        $('.store-content .image-store-swiper .cover img').click(function(){
            var $el_images = $('.store-content .image-store-swiper .cover img');
            // zoom_image_viewer($el_images);
        });

        function zoom_image_viewer($el_images){

            var layout_html = '';
                layout_html += '<div class="zoom-image-container">';
                layout_html += '<div class="close-icon"></div>';
                layout_html += '<div class="content-wrapper">';
                layout_html += '<div class="swiper-container">';
                layout_html += '<div class="swiper-wrapper">';
                layout_html += '</div>';
                layout_html += '<div class="swiper-button-next"></div><div class="swiper-button-prev"></div>';
                layout_html += '</div></div></div>';

            // 
            $('body').append(layout_html);

            // 
            $('.zoom-image-container').click(function(){
                $('.zoom-image-container').remove();
            });

            // 
            $('.zoom-image-container .content-wrapper').click(function(event){
                event.stopPropagation();
            });

            // 
            var cover_height = $('.zoom-image-container .content-wrapper').css('height');

            // 
            var $el_swiper_wrapper = $('.zoom-image-container .swiper-wrapper');
            $el_images.each(function(){
                var item_img_html = '<div class="swiper-slide"><div class="cover" style="height:' + cover_height + '"><img class="imgScaledown" src="' + this.src + '"/></div></div>';
                $el_swiper_wrapper.append(item_img_html);
            });

            // SWIPER PLUGIN: CONFIG
            var swiper = new Swiper('.zoom-image-container .swiper-container', {
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
            });
        }

		// FORM INVOKE: QUICK ORDER
		var quick_order = new Form_Invoke({
		    containerID : 'order-store',
		    formID : 'quick_order',
		    xhrURL : url_base + '/xhr/_order_store/'
		}).restart();

		// SET CACHE HISTORY: view_item_history
		cache_history.set_cache_history('view_item_history', '<?=$this->alias_book_case_id;?>');
		</script>
<?php
	}
}
?>