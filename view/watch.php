<?php
$TABLE = BOOK_PRODUCT;
$itemId = $curId;
$query = "
SELECT a.*, a.id as BOOK_ID, b.name AS CATES_NAME, c.name AS CATECHILD_NAME 
FROM $TABLE AS a 
LEFT JOIN CATES AS b ON a.CATES_ID = b.ID 
LEFT JOIN CATECHILD AS c ON a.CATECHILD_ID = c.ID 
WHERE a.id = $itemId
";
?>
<section class="container">
	<div class="view-item-container">
		<div class="product-row row">
			<div class="view-item-slider swiper-container">
				<div class="swiper-wrapper">
<?php
// FETCH
$mainRi->selectQuery($query);
$rowBOOK = $mainRi->_rendata[0];
$getIMG = get_link_img_from_str($rowBOOK['IMAGE']);
$getVIDEO = get_link_img_from_str(str_replace('...', '', $rowBOOK['VIDEO']));
// IMAGE
foreach ( $getIMG as $imgUrl ) {
?>
					<div class="swiper-slide">
						<img class="item-img imgCover" src="<?=$imgUrl;?>"/>
					</div>
<?php
}
// VIDEO
foreach ( $getVIDEO as $videoUrl ) {
?>
					<div class="swiper-slide">
						<iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?=substr($videoUrl, -11);?>"></iframe>
					</div>
<?php
}
?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<div class="view-item-info">
				<div class="contact-box">
					<a href="<?=WHATSAPP_PAGE_URL;?>" class="icon icon-svg whatsapp-icon"></a>
					<p class="line">Contact us via</p>
					<p class="line">Whatsapp: +84 904880708</p>
					<p class="line">Instagram: phan.official9</p>
					<p class="line">Email: phanofficial2014@gmail.com</p>
					<p class="line">Thank you for shopping with Phan Official</p>
				</div>
				<div class="descript-box">
					<?=$rowBOOK['DESCRIPTION'];?>
				</box>
			</div>
		</div>
	</div>
	<div class="category-title recommended">Recommended Product</div>
	<div class="grid-container" data-stl-grid-item>
		<div class="row" data-content>
<?php
$query = "SELECT * FROM $TABLE WHERE CATES_ID = {$rowBOOK['CATES_ID']} AND ID < {$rowBOOK['ID']} ORDER BY ID DESC LIMIT 0, {$map_limit_book['GRIDBLOCK_HOME']}";
?>
		</div>
		<input type="hidden" data-query value="<?=$query;?>">
		<div class="loader-wrapper" data-loader></div>
	</div>
</section>
<script>
var swiper = new Swiper('.view-item-slider', {
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	}
});
$(window).on('resize', function () {
	swiper.update();
});
</script>