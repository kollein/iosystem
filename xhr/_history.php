<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

//call Class by Magic
$ajaxData = new Model_sqlDynamic($conn);
// JSON from POST AJAX
$history_data_json = $_POST['suggest'];
// REVERSE: SHOW LAST IS ON TOP
$history_data_json = $history_data_json ? array_reverse($history_data_json) : null;
// COLLECTION DATA FROM QUERY
$collection_book_row = [];
// CHECK IF HISTORY DATA IS NOT EMPTY
if( $history_data_json ){
	// MAP COLLECTION ID
	$map_collection_alias_id = ['t' => 'TRADITIONAL', 'p' => 'PRODUCT', 's' => 'SHARE', 'i' => 'INFO', 'w' => 'WHERE'];
	$map_collection_mix_1 = ['t' => 'PRICE', 'p' => 'PRICE', 's' => 'PRICE', 'i' => 'AUTHOR', 'w' => 'CHECKIN_PER_YEAR'];
	// QUERY MULTI-TABLE IN ONE
	foreach( $history_data_json as $k => $v ){
		$stack_alias_id = explode('_', $k);
		$alias = $stack_alias_id[0];
		$id = $stack_alias_id[1];
		$is_mix_1 = $map_collection_mix_1[$alias];
		$book_case = $map_collection_alias_id[$alias];
		$table = 'BOOK_'.$book_case;
		$query = "
		SELECT ID, TITLE, IMAGE, DESCRIPTION, VIEW, $is_mix_1 AS 'MIX_1', if(ID = 0, '$book_case', '$book_case') AS 'BOOK_CASE' FROM $table WHERE id = $id";
		$ajaxData->selectQuery($query);
		// CHECK
		if( $ajaxData->_rendata ){
			array_push($collection_book_row, $ajaxData->_rendata[0]);
		}
	}
	// FINAL SHOW
	if( $collection_book_row ){
		
	    foreach( $collection_book_row as $row ){

	        $getIMG = get_link_img_from_str($row['IMAGE']);
	        $urlTitle = convertAlias($row['TITLE'], true);
	        $go_by_bookcase = strtolower( substr( $row['BOOK_CASE'], 0, 1 ) );
	        $url_go_post = generate_url_by_map([$go_by_bookcase, $row['ID'], $urlTitle], true, true);
?>
	        <li>
	            <div class="lockup-product row-nw">
	                <div class="cover"><a href="<?=$url_go_post;?>"><img class="imgCover" src="<?=$getIMG[0];?>"/></a></div>
	                <div class="info">
	                    <h3 class="title"><a href="<?=$url_go_post;?>"><?=$row['TITLE'];?></a></h3>
	                    <div class="specification">
<?php
	if( $row['BOOK_CASE'] == 'PRODUCT' || $row['BOOK_CASE'] == 'TRADITIONAL' ){
?>
	    <div>
	        <span><?=number_format($row['MIX_1']);?><span class="m-unit-currency">đ</span></span>
	        <span><?=$row['VIEW'];?> quan tâm</span>
	    </div>
<?php
	}elseif( $row['BOOK_CASE'] == 'INFO' ){
?>
	    <div>
	        <span><?=$row['MIX_1'];?></span>
	        <span><?=$row['VIEW'];?> lượt xem</span>
	    </div>
<?php
	}elseif( $row['BOOK_CASE'] == 'WHERE' ){
?>
	    <div>
	        <span><?=number_format($row['MIX_1']);?> lượt khách / năm</span>
	        <span><?=$row['VIEW'];?> quan tâm</span>
	    </div>
<?php
	}
?>
	                    </div>
	                    <div class="description">
	                        <?=decodeURI($row['DESCRIPTION'], 0, 200);?>
	                    </div>
	                </div>
	            </div>
	        </li>
<?php
	    }
	}
}else{

    print'
    <div class="lockup-product">
        <h2>Lịch sử trống.</h2>
    </div>
';
}
?>