<?php
/**
* VIEW_t
*/
class Model_t extends Template_watch{
    
    function __construct(){
        // PARENT
        parent::__construct();
        // SHOW TIME
        $this->header_html();

        $this->traditional_shop_banner_html();

        $this->main_block_html();

        $this->close_header_html();
    
        $this->footer_js();
    }

    // MAKE MAIN QUERY
    function make_main_query(){

    	// MAIN FETCH DATA WITH MULTI TABLES BY ALIAS
    	$query = "
    		SELECT a.*, a.id as BOOK_ID, b.name AS CATES_NAME, c.name AS CATECHILD_NAME, d.*, d.name AS TRUSTED_SHOP_NAME, e.name AS LIST_PROVINCE_VIETNAM_NAME
    		FROM $this->TABLE AS a 
    		LEFT JOIN CATES AS b ON a.CATES_ID = b.ID 
    		LEFT JOIN CATECHILD AS c ON a.CATECHILD_ID = c.ID 
    		LEFT JOIN TRUSTED_SHOP AS d ON a.TRUSTED_SHOP_ID = d.ID 
    		LEFT JOIN LIST_PROVINCE_VIETNAM AS e ON d.LIST_PROVINCE_VIETNAM_ID = e.ID
    		WHERE a.id = $this->itemId
    	";

    	return $query;
    }

    // PREPEND
	function header_html(){

?>
<script src="<?=URLBASE;?>/js/colorist2.js"></script>
<?php
		// ADDPEND
		parent::header_html();
	}

	function traditional_shop_banner_html(){

		// ASSIGN
    	$getIMG_banner = get_link_img_from_str($this->rowItem['BANNER_IMAGE']);
?>
<div class="banner-container panel">
    <div class="holder cover">
        <img class="imgCover" id=":_trusted-shop-banner" src="<?=$getIMG_banner[0];?>" onload="Image_Dominant_Color.getImageData(this.getAttribute('id'), true)"/>
        <div class="holder-content content" data-dominant-query=":_trusted-shop-banner" data-dominant-set-type="background">
            <div class="name"><?=$this->rowItem['TRUSTED_SHOP_NAME'];?></div>
            <div class="info-wrapper wrapper">
                <ul>
                    <li>
                        <span class="icon _address"></span>
                        <span class="text"><?=$this->rowItem['ADDRESS'];?> (<?=$this->rowItem['LIST_PROVINCE_VIETNAM_NAME'];?>)</span>
                    </li>
                    <li>
                        <span class="icon _mobile"></span>
                        <span class="text"><?=$this->rowItem['PHONE_NUMBER'];?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
	}
}
?>