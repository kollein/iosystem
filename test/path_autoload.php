<?php

$uix = 'Xhr_Router_cates_page';

$stack_uix = explode('_', $uix);
$path = '';
foreach( $stack_uix as $word ){
	if( ctype_upper($word[0]) ){
		$path .= $word .'/';
	}else{
		// FOUNDED FILE NAME
		$path .= $word .'_';
	}
}

$ready_path = substr($path, 0, -1) .'.php';
echo $ready_path;
?>