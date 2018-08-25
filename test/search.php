<?php
$key_search = 'qian jesn';
$key_search_underscore = '';
$stack_key_search = explode(' ', $key_search);
foreach( $stack_key_search as $word ){
	$word_lenght = strlen($word);
	$first_char = substr($word, 0, 1);
	$last_char = substr($word, -1);
	echo $word_lenght.' : '.$first_char.' : '. $last_char.'<br>';
	$word_underscore = $first_char.str_repeat('_', $word_lenght - 2).$last_char;
	$key_search_underscore .= $word_underscore.' ';
}
echo $key_search_underscore;
?>