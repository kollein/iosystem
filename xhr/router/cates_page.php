<?php
class Xhr_Router_cates_page extends Xhr_Router_page{

	function make_query(){
		$where = "WHERE id NOT IN ({$this->content['id_collection']}) {$this->content['filter_by_cates_id']} {$this->content['filter_by_catechild_id']} LIMIT 0 ,". $this->map_limit_book['GRIDBLOCK_CATES_RECOMENDED_LOADMORE'];
		// NOW READY TO JOIN
		$query = "SELECT * FROM {$this->content['table']} $where";
		return $query;
	}
}
?>