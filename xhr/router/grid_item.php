<?php
include '../../config.php';
include '../../function.php';
include '../../autoload.php';

$xhr_query = $_POST['query'];
$xhr_state = $_POST['state'];

// the callback function
function next_stack($matches) {
  global $map_limit_book, $xhr_state;
  if ( $xhr_state === 'default' ) {
    $strLimit = $matches[1].$matches[2].$matches[3].$map_limit_book['GRIDBLOCK_HOME'];
  } else {
    
    if ( $matches[2] === '0' ) {
      $matches2 = $matches[4];
    } else {
      $matches2 = $matches[2] + $map_limit_book['GRIDBLOCK_HOME_LOADMORE'];
    }

    $strLimit = $matches[1].$matches2.$matches[3].$map_limit_book['GRIDBLOCK_HOME_LOADMORE'];
  }
  return $strLimit;
}
$query = preg_replace_callback(
          "|(LIMIT )(\d+)(, )(\d+)|",
          "next_stack",
          $xhr_query);
$TABLE = preg_replace("|(?:.+?) from ([a-z\_]+?) (?:.*)|i", "$1", $xhr_query);
// FETCH
$template_grid = new Template_grid($map_go_view);

if ( $TABLE !== 'BOOK_LIST_REAL_PHOTO' ) {

  $mainRi = new Model_sqlDynamic($conn);
  $mainRi->selectQuery($query);
  $rowBOOK_s = $mainRi->_rendata;
  $data_json = $template_grid->grid_3_json($rowBOOK_s, $TABLE);
  
} else {
  $strLIMIT = preg_replace(
    "|(?:.+?) LIMIT (\d+)(, )(\d+)|",
    "$1|$3",
    $query);
  $dataArr = explode('|', $strLIMIT);
  $data_json = $template_grid->grid_3_json_rp($dataArr[0], $dataArr[1]);
}

$data_json['query'] = $query;
echo json_encode($data_json);
?>