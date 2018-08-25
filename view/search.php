<?php
if(!$_GET['q']){
    print'<script>window.location.href = "'.URLBASE.'";</script>';
    exit;
}
// ASSIGN @$key_search
$key_search = trim($_GET['q']);
$search_result_data = $mainRi->get_search_result_data($key_search, ['TRADITIONAL', 'PRODUCT', 'SHARE', 'INFO', 'WHERE']);
// COMPARE: KEY_WORD ~ KEY_SEARCH
$final_result = [];
$key_search_latin = convertAlias($key_search);
$fractional_for_percent = 0;
foreach( $search_result_data as $row ){
    $fractional_for_percent++;
    $key_word_by_title = convertAlias($row['TITLE']);
    $key_word_by_tag_str = convertAlias($row['TAG']);
    $key_word_by_tag_arr = explode(',', $key_word_by_tag_str);
    // CALC: percent from two case
    similar_text($key_search_latin, $key_word_by_title, $similar_text_percent_by_title);
    similar_text($key_search_latin, $key_word_by_tag_arr[0], $similar_text_percent_by_tag);
    // CHECK
    if( $similar_text_percent_by_title > 10 || $similar_text_percent_by_tag > 10 ){

        $similar_text_percent = $similar_text_percent_by_title > 10 ? $similar_text_percent_by_title : $similar_text_percent_by_tag;
        $similar_text_percent = $similar_text_percent + ($fractional_for_percent / 10000);
        // BOUND KEY AS STRING "", BECAUSE KEY IS FLOAT
        $final_result["$similar_text_percent"] = $row;
    }
}
// SORT PERCENT DESCREASING
krsort($final_result);
// COUNT NUMBER ITEM IN RESULT
$all_item = count($final_result);
// PROCCESS FOR PAGINATION
$mixPagi = pagination($_GET['p'], $all_item, 40);
// USE QUERY NO LIMIT : CHUNK DATA INTO MANY GROUP, ONE GROUP AS A PAGE
$rowBOOK_group_s = array_chunk($final_result, 40, true);
?>
<section id="show-container" class="block-container">
    <div class="search-page-container yt-card">
        <div class="result-search-container">
            <div class="search-header"><p>Khoảng <?=number_format($all_item);?> kết quả</p></div>
            <div class="search-content">
                <ol>
<?php
if( $rowBOOK_group_s ){
    foreach( $rowBOOK_group_s[$mixPagi['page'] - 1] as $row ){
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
}else{

    print'
    <div class="lockup-product">
        <h2>Tìm kiếm thay thế cho <a class="color-blue" href="https://www.google.com/search?as_sitesearch=lamsaode.com&as_q='.$key_search.'">'.$key_search.'</a></h2>
    </div>
';
}
?>
                </ol>
<?php
//Notice: $mixPagi are tranfered to
include 'view/stack/pagination.php';
?>
            </div>

        </div>
    </div>
</section>
<script>
// SET LOCAL STORAGE : search_history
cache_history.set_cache_history('search_history', '<?=$key_search;?>');
// UPDATE: SEARCH HISTORY IN DATABASE
var update_search_history = new Cache_Invoke({
    cache_name: 'search_history',
    xhrURL: url_base + '/xhr/_user_cache_update/'
}).restart();
</script>