<?php
if( $curAdapter == 'search' ){
    include 'search.php';
}elseif( $curAdapter > 12 ){
    include strtolower($TABLE).'.php';
}else{
    //CHECK CATEID HAS CATECHILD OR NO
    $where = "WHERE cates_id = $curAdapter";
    $cms->countRow(CATECHILD, $where);
    $numRow_catechild = $cms->_rendata;

    if( $curAdapter > 0  & !$numRow_catechild || $curAdapter > 0 & $curCatechildid > 0 ){
        include 'books.php';
    }else{
        include 'category.php';
    }
}
?>