<?php
/**
* VIEW_s
*/
class Model_s extends Template_watch{
    
    function __construct(){
        // PARENT
        parent::__construct();
        // SHOW TIME
        $this->header_html();

        $this->main_block_html();

        $this->close_header_html();
    
        $this->footer_js();
    }

    // MAKE MAIN QUERY
    function make_main_query(){

    	// MAIN FETCH DATA WITH MULTI TABLES BY ALIAS
    	$query = "
    		SELECT a.*, a.id as BOOK_ID, b.name AS CATES_NAME, c.name AS CATECHILD_NAME 
    		FROM $this->TABLE AS a 
    		LEFT JOIN CATES AS b ON a.CATES_ID = b.ID 
    		LEFT JOIN CATECHILD AS c ON a.CATECHILD_ID = c.ID 
    		WHERE a.id = $this->itemId
    	";

    	return $query;
    }
}
?>