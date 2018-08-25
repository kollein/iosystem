<section class="container">
	<div class="grid-container" data-stl-grid-item>
		<div class="row" data-content>
	<?php
	$TABLE = BOOK_PRODUCT;
	$query = "SELECT * FROM $TABLE ORDER BY ID DESC LIMIT 0, {$map_limit_book['GRIDBLOCK_HOME']}";
	?>
		</div>
		<input type="hidden" data-query value="<?=$query;?>">
		<div class="loader-wrapper" data-loader></div>
	</div>
</section>