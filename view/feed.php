<?php
if( $curStack == FEED_HISTORY ){
    include'view/stack/history.php';
}elseif( $curStack == FEED_ABOUT ){
    include'view/stack/about.php';
}else{
    include'view/stack/terms.php';
}
?>