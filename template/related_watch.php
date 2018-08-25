<?php
// GRID : TEMPLATE
class Template_related_watch extends Template_grid{

	// IDENTIFY ITEM IN WIDTH DATA
	function identify_item_in_width(){
		// MAP WIDTH
		$map_width_by_book_case = ['TRADITIONAL' => '', 'SHARE' => '', 'PRODUCT' => '', 'INFO' => ''];
		// RETURN CSS: @className
		return $map_width_by_book_case[$this->_book_case];
	}

	// HTML - HEADER
	function header_html( $map_load_more_data, $title ){
?>
		<div id="<?=$map_load_more_data['data_container_id'];?>">
			<div class="_loadmore_">
<?php
	}

	// HTML - CLOSE:HEADER
	function close_header_html(){
?>
			</div>
		</div>
<?php
	}

	// SHOW ITEM BY BOOK CASE
	function show_item_by_book_case($row){
		$alias_book_case_table = $this->_map_go_view[$this->_TABLE];
		$urlTitle = convertAlias($row['TITLE'], true);
		$url_go_post = generate_url_by_map([$alias_book_case_table, $row['ID'], $urlTitle], true, true);
	    $getIMG = get_link_img_from_str($row['IMAGE']);

	    // CHECK BOOK CASE
	    if( $this->_book_case == 'INFO' ){
?>
CHUA BIET
<?php
	    }else{
?>
			<div class="cover-img col-d104">
			    <a class="title" href="<?=$url_go_post;?>">
			        <img class="imgCover" src="<?=$getIMG[0];?>"/>
			    </a>
			</div>
			<div class="title-wrapper col-d106">
			    <a class="title" href="<?=$url_go_post;?>"><?=$row['TITLE'];?></a>
			    <div class="price"><?=number_format($row['PRICE'], 0, ',', '.');?> đ</div>
			    <div class="view"><?=number_format($row['VIEW']);?> quan tâm</div>
			</div>
<?php
		}
	}
}
?>