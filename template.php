<?php
if( $curId ){
	// GET THIS CATE
	$TABLE_BOOK_CASE = get_book_table_name($curAdapterOrigin);
	// QUERY STATEMENT
    $where = "WHERE id = $curId";
    $TABLE = $TABLE_BOOK_CASE;

	//RENDER: info to Display <title> <meta> in @header.php
	$mainRi->selectRow($TABLE, $where);
	$row = $mainRi->_rendata[0];//FETCH-OUT FOR HEADER SHOW TITLE , META: DESCRITION-KEYWORD
}else{
    $row = null;
}
// HEADER
include 'view/header.php';
// CONTENT
include 'view/'.$curAdapter.'.php';
// FOOTER
include 'view/footer.php';
?>