<?php
include '../config.php';
include '../function.php';
include '../autoload.php';
//call Class by Magic
$ajaxData = new Model_sqlDynamic($conn);
// JSON FROM AJAX
$content = $_POST['suggest'];
// ASSIGN
$reference = $content['reference'];
// CHECK TO LOAD VIEW FOR THIS ROUTER
if( $reference ){
	if( !in_array($reference, ['home_page', 'cates_page']) ){
		$router = 'watch_page';
		// INIT: CONSTRUCTOR TEMPLATE GRID
		$tpl_grid = new Template_related_watch($ajaxData);
	}else{
		$router = $reference;
		// INIT: CONSTRUCTOR TEMPLATE GRID
		$tpl_grid = new Template_grid($ajaxData);
	}
	// INIT:
	$uix = 'Xhr_Router_'. $router;
	$init_router = new $uix($content);
}
?>