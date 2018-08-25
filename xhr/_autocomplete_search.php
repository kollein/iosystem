<?php
include '../config.php';
include '../function.php';
include '../autoload.php';

//call Class by Magic
$ajaxData = new Adapter_search($conn);
// GET USER DATA
$user_data = $ajaxData->getUserWithHash();
// JSON from POST AJAX
$content = $_POST['suggest'];
// GET KEY SEARCH: CONVERT IT TO LATIN
$key_search = convertAlias(trim($content['key_search']));
// MAKE DATA JSON
$history_data_json = json_decode($content['search_history'], true);
// CHECK IF USER LOGGED
if( $user_data['ID'] ){
	// GET SEARCH HISTORY FROM DATABASE HAS INSERT BEFORE
	$where = "WHERE user_id = {$user_data['ID']}";
	$ajaxData->selectRow(USER_CACHE, $where);
	$history_data_json_from_db = json_decode($ajaxData->_rendata[0]['SEARCH_HISTORY'], true);
	// RE-ASSIGN
	$history_data_json = empty($history_data_json) ? $history_data_json_from_db : $history_data_json;
}
// CHECK HISTORY DATA JSON
$search_data_from_history_arr = [];
if( is_array($history_data_json) ){
	foreach( $history_data_json as $key_word => $timestamp ){
		array_push($search_data_from_history_arr, $key_word);
	}
}
// CHECK KEY SEARCH
if( $key_search ){
	// GET DATA KEYWORD FROM MULTI-ROW IN MULTI-TABLE WHER TAG-COLUMN
	$row_search_tag_data = $ajaxData->get_all_tag_data(['TRADITIONAL', 'PRODUCT', 'SHARE', 'INFO', 'WHERE']);
	$search_tag_data_str = '';
	/*
	READ DETAIL PATTERN TO SEE HOW:
	*/
	$remove_residue_char_pattern = [['/^(,)(.*)/s', '/(.*)(,)$/s', '/(.*)(, *)(.*)/s'], ['$2', '$1', '$1,$3']];
	foreach( $row_search_tag_data as $row ){
		$per_tag_data_str = preg_replace($remove_residue_char_pattern[0], $remove_residue_char_pattern[1], $row['tag']);
		$search_tag_data_str .= $per_tag_data_str. ",";
	}
	// CONVERT TO ARRAY
	$search_tag_data_arr = explode(',', $search_tag_data_str);
	// REMOVE EMPTY ELEMENT
	$search_tag_data_arr = array_filter($search_tag_data_arr, function($value) { return trim($value) !== ''; });
	// COMBIND TWO ARRAY DATA
	$merge_keyword_data = array_merge($search_data_from_history_arr, $search_tag_data_arr);
	// REMOVE DUPLICATE ELEMENT
	$merge_keyword_data = array_unique($merge_keyword_data);
	// FINAL COMPARE: KEY_WORD ~ KEY_SEARCH
	$final_result = [];
	foreach( $merge_keyword_data as $key_word ){
		similar_text($key_search, $key_word, $similar_text_percent);
		if( $similar_text_percent > 30 ){
			$final_result[$similar_text_percent] = $key_word;
		}
	}
	// SORT PERCENT DESCREASING
	krsort($final_result);
}else{
	// SHOW LAST KEY_SEARCH ON TOP
	$final_result = array_reverse($search_data_from_history_arr);
}
// FINAL CHECK
if( $final_result ){
?>
<ul>
<?php
	// FINAL SHOWTIME
	foreach( $final_result as $percent => $key_word ){
			$title_url = str_replace(' ', '+', $key_word);
			$url_go_search = generate_url_by_map([GO_SEARCH, '?q='.$title_url]);
			$i++;
			// LIMIT SHOW
			if( $i === 6 ){
				break;
			}
?>
<li>
    <a href="<?=$url_go_search;?>">
        <div class="icon"></div>
        <div class="text"><?=$key_word;?></div>
    </a>
</li>
<?php
	}
?>
</ul>
<?php
}
?>