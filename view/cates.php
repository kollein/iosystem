<?php
// GET THIS CATE
$thisCate = getThisCate($cateMap, $curAdapterOrigin, 'name');
// CHECK
if( !$thisCate ){
	go_404();
	exit;
}
// ASSIGN TABLE BOOK
$TABLE = 'BOOK_'.$thisCate['BOOK_CASE'];
// ASSIGN BOOK CASE ALIAS
$book_case_alias = strtolower(substr($thisCate['BOOK_CASE'], 0, 1));
?>

<section class="container">
	<div class="category-title"><?=$thisCate['NAME'];?></div>
	<div class="grid-container" data-stl-grid-item>
		<div class="row" data-content>
<?php
$query = "SELECT * FROM $TABLE WHERE CATES_ID = {$thisCate['ID']} ORDER BY ID DESC LIMIT 0, {$map_limit_book['GRIDBLOCK_HOME']}";
?>
		</div>
		<input type="hidden" data-query value="<?=$query;?>">
		<div class="loader-wrapper" data-loader></div>
	</div>
</section>