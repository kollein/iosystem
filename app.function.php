<?php
function getCurId($str){
    $str = trimChar('\d\-',$str);
    $arr=array();
    $stack=explode('-',$str);
    $stack = array_slice($stack, -2, 2);//incase TITLE has number
    $i=0;
    foreach($stack as $v){
        $vNow=trimChar('\d',$v);
        if($vNow){
            $arr[$i] = $vNow;
            $i++;
        }
    }
    return $arr;
}
function getStrSearch($str){
    return str_replace('-',' ',$str);
}

function trimChar($valid,$str){
    if($valid=='Ofcache'){
        return preg_replace("/(=|\|)/",'',$str);
    }else{
        $str=strtolower(trim($str));
        return preg_replace("/[^$valid]+/i",'',$str);
    }
}

function convertAlias($cs,$isUrl=false){
$vietnamese=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
"è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
"ì","í","ị","ỉ","ĩ",
"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
"ỳ","ý","ỵ","ỷ","ỹ",
"đ",
"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
"Ì","Í","Ị","Ỉ","Ĩ",
"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
"Đ");
$latin=array("a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a",
"e","e","e","e","e","e","e","e","e","e","e",
"i","i","i","i","i",
"o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
"u","u","u","u","u","u","u","u","u","u","u",
"y","y","y","y","y",
"d",
"A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A",
"E","E","E","E","E","E","E","E","E","E","E",
"I","I","I","I","I",
"O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
"U","U","U","U","U","U","U","U","U","U","U",
"Y","Y","Y","Y","Y",
"D");
$csLatin= str_replace($vietnamese,$latin,$cs);
if($isUrl==true){$csLatin=strtolower(preg_replace('/-+/','-',str_replace(' ','-',trimChar('\s\w',$csLatin))));}
return $csLatin;
}

function getParamRequest($param, $str){
    $fullParamRequest = preg_replace('#(.*?)([\?&])'.$param.'=([a-z0-9+]*)&?(.*)#is', '$2'.$param.'=$3', $str);
    if($fullParamRequest == $str){
        if( strpos($str, '?') === false ){
            $queryMark = '?';
        }else{
            $queryMark = '&';
        }
        $fullParamRequest = $queryMark.$param.'=null';
        //RESET: $str
        $str .= $fullParamRequest;
    }
    $stack = explode('=',$fullParamRequest);
    return array('url' => $str, 'full' => $fullParamRequest, 'markparam' => $stack[0], 'param' => $param, 'value' => $stack[1]);
}

function plusIDXArr($arr,$start){
    if($arr){
        $maxKey=count($arr);
        $newKeys=range($start,$maxKey);
        return array_combine($newKeys,$arr);//now: index by $start ++
    }else{
        return false;
    }
}

function saveBase64Image($destinate, $filename, $base64IMG){
  // REMOVE STRING IS UN-NECCESSARY IN BASE64
  $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$base64IMG));
  // CHECK DIR IF NOT EXIST MAKE DIR
  if ( !file_exists($destinate) ){
    // MAKE DIRECTORY
    mkdir($destinate, 0755, true);
  }
  // SAVE IMAGE INTO DIR
  $savedCheck = file_put_contents($destinate.'/'.$filename,$data);
  if($savedCheck>0){
     return true;
  }else{
     return false;
  }
  
}

function decodeURI($content, $start, $length){
    $content = urldecode($content);
    if($length){
        $content = preg_replace('/\s+|&nbsp;/s',' ',trim(substr(strip_tags($content),$start, $length)));
        //AVOID: ? Vietnamese crash out
        $content = substr($content, 0, strrpos($content,' '));
    }
    return $content;
}

function get_link_img_from_dom($html, $encoded){
    if($encoded){
        $html = urldecode($html);
    }
    $map_link_output = [];
    if( $html ){
        $dom = new domDocument;//METHOD valid by PHP 5.2.x
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $dom->preserveWhiteSpace = false;
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $image) {
          array_push( $map_link_output, $image->getAttribute('src') );
        }
    }
    return $map_link_output;
}

function get_link_img_from_str($strContent, $strDelit = ','){
    $map_link_output = [];
    foreach ( explode($strDelit, $strContent) as $value ) {
      if( $value ){
        array_push($map_link_output, $value);
      }
    }
    return $map_link_output;
}

function formatDateFromTimestamp($format, $timestamp){
    $timestamp = strtotime($timestamp);
    $myWeekDay = array(1=>'Thứ Hai','Thứ Ba','Thứ Tư','Thứ Năm','Thứ Sáu','Thứ Bảy','Chủ nhật');

    if($format == 'N'){
        $out = $myWeekDay[date($format, $timestamp)];
    }else{
        $out = date($format, $timestamp);
    }

    return $out;
}

// DATEDIFF WITH ALIAS
function date_diff_text_ago($start_date, $showMap = false){
    //PHP 5 >= 5.3.x
    $start_date = new DateTime($start_date);
    $since_start = $start_date->diff(new DateTime(_TIMESTAMP));
    $map = array(
        'y' => 'năm',
        'm' => 'tháng',
        'd' => 'ngày',
        'h' => 'giờ',
        'i' => 'phút',
        's' => 'giây');
    $i = 0;
    $out = 'mới đây';
    if($outMap == false){
        foreach ($since_start as $k => $v) {
            $i++;
            if ($i == 7) {
                break;
            }
            if ($v > 0) {
                $extS = '';
                if ($v > 1) {
                    $extS = 's';
                }
                $out = 'Cách đây ' . $v . ' ' . $map[$k];
                break;
            }
        }
    }else{
        $out = $since_start;//RETURN OBJECT: using : $obj->days
    }
    return $out;
}

function remove_element_with_value($array, $key, $map_value){
    //$array : multidimension array
    foreach( $array as $subKey => $subArray ){
        foreach( $map_value as $value ){
            if( $subArray[$key] == $value ){
                unset($array[$subKey]);
            }
        }
    }
    return $array;
}

function makeElementAtTop($array, $key, $value){
    //$array : multidimension array
    foreach( $array as $subKey => $subArray ){
        if( $subArray[$key] == $value ){
            $cachedE = $subArray;
            unset($array[$subKey]);
            array_unshift($array,$cachedE);
            break;
        }
    }
    return $array;
}

function pagination($page, $all_item, $numItemPerPage){
    $page += 0;
    if($page > 0){
        $page = $page;
    }else{
        $page = 1;
    }
    $startPageMysql = ($page - 1) * $numItemPerPage;
    $numPage = $all_item % $numItemPerPage == 0 ? $all_item / $numItemPerPage : intVal($all_item / $numItemPerPage)+1;
    // CASE: $_GET['p'] > $numPage
    $page = $page > $numPage ? 1 : $page;
    return array('page'=>$page, 'num_page'=>$numPage, 'start_page'=>$startPageMysql, 'num_item_per_page'=>$numItemPerPage);
}
/*MySQL RUN NATIVE*/
function showCache($crazy)
{
    if($crazy == 'vn'){
        $cache = LANG_VN_JSON;
    }elseif($crazy == 'en'){
        $cache = LANG_EN_JSON;
    }else{
        $cache = CONFIGURATION_JSON;
    }
    return $cache;
}
function pickIcache($crazy, $phrase)
{
    $cache = showCache($crazy);

    $stack = json_decode($cache, true);
    foreach ($stack as $key => $val) {
        if ($key == $phrase) {
            $out = $val ? $val : "$phrase::$crazy-empty";
            break;
        } else {
            $out = "$phrase::unsigned";
        }
    }
    return $out;
}
/* CATES */
function getThisCate($cateMap, $valueOfCate, $typeOfCate){

    $thisCate = false;
    foreach($cateMap as $cate){
      if( $typeOfCate == 'id' ){
        if( $cate['ID'] == $valueOfCate ){
          $thisCate = $cate;
          break;
        }
      }else{
        $cateInMap_urlType = convertAlias($cate['NAME'], true);
        if( $cateInMap_urlType == $valueOfCate ){
          $thisCate = $cate;
          break;
        }
      }
    }
    return $thisCate;
}
/* GET BOOK_CASE FROM ADAPTER : 't,p,w,i' */
function get_book_table_name($adapter){
  global $map_go_view;
  $output = null;
  foreach( $map_go_view as $key => $v ){
    if( $v == $adapter ){
      $output = $key;
      break;
    }
  }
  return $output;
}
/* HASH: ALPHA_NUMBERIC */
function alpha_numberic_hash($length, $with_line = true){
  $two_line_char = $with_line === true ? '-_' : '';
  // EVERY SHUFFLE LENGTH: 64 or 62 chars
  $shuffle = str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $two_line_char);
  $shuffle_length = strlen($shuffle);
  $multiply = 1;
  // CALC MANY TIME FOR MULTIPLY
  if( $length > $shuffle_length ){
    $multiply = intval($length / $shuffle_length) + 1;
  }
  // MULTIPLY NOW
  for( $i = 1; $i <= $multiply; $i++ ){
    $valid_hash .= str_shuffle($shuffle);
  }
  return substr($valid_hash, -$length);
}
/* COLLECTION URL BY STRING MAP */
function generate_url_by_map($str_map, $use_URLBASE = true, $use_HTML_EXT = false){
  $output = $use_URLBASE ? URLBASE.'/' : '';
  $number_el_map = count($str_map);
  // LOOP
  foreach( $str_map as $v ){$i++;
    if( $number_el_map == $i && $use_HTML_EXT ){
      $output .= $v.HTML_EXT;
    }else{
      if( substr_count($v, '?') || !$v ){
        $forward_flash = '';
      }else{
        $forward_flash = '/';
      }
      $output .= $v.$forward_flash;
    }
  }
  return $output;
}
/*
COLLECTION ID BY BOOK_CASE:
@$content : JSON  
*/
function collection_id_by_book_case($content, $alias){
    $mixed_multi_id = [];
    $i = 0;
    foreach( $content as $key => $item ){
        $mixed_id = $key;
        if( substr_count($mixed_id, $alias) > 0 ){
            $id = explode('_', $mixed_id)[1];
            // PRESERVE NATURAL KEY
            $mixed_multi_id[$i] = $id;
            $i++;
        }
    }
    // SORT KEY BY DESC
    krsort($mixed_multi_id);
    return $mixed_multi_id;
}
/* GET LSD BY CASH */
function get_lsd_by_cash($cash){
    $cash /= 1000;
    if( $cash > 50 ){
      $lsd = 5 + ($cash * 3 / 100);
    }else{
      $lsd = $cash / 10;
    }
    return floor($lsd);
}
/* HTML ENTITIES BY MAP */
function html_entities_by_map($mix, $map, $child_map){
    // MIX WITH MAP
    foreach( $map as $column_name ){
      $column_value = $mix[$column_name] == null ? '' : $mix[$column_name];
      if( in_array($column_name, $child_map) ){
        $column_value = htmlentities($mix[$column_name], ENT_QUOTES);
      }
      $content_mixed[$column_name] = $column_value;
    }
    return $content_mixed;
}
/* GO 404*/
function go_404(){
    print "
<script>
    window.location.href = '/404/';
</script>
    ";
}
?>