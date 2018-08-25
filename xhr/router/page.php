<?php
class Xhr_Router_page{
	
	public $router;
	public $template;
	public $content;
	public $map_limit_book;

	public function __construct($content){
		global $router, $tpl_grid, $map_limit_book;
		// ASSIGN:
		$this->router = $router;
		$this->template = $tpl_grid;
		$this->map_limit_book = $map_limit_book;
		// PROCCESS:
		$this->ready_data($content);
		$this->show_time();
	}

	function ready_data($content){
		// ASSIGN:
		$table = "BOOK_" . $content['book_case'];
		// STACK SUGGEST TO GET: CATES_ID, CATECHILD_ID
		$stack_suggest = explode('|', $content['suggest']);
		// CATES_ID
		if( $stack_suggest[1] ){
			$filter_by_cates_id = "AND cates_id = ". $stack_suggest[1];
		}
		// CATECHILD_ID
		if( $stack_suggest[2] ){
			$filter_by_catechild_id = "AND catechild_id = ". $stack_suggest[2];
		}
		// PUSH
		$content['table'] = $table;
		$content['filter_by_cates_id'] = $filter_by_cates_id;
		$content['filter_by_catechild_id'] = $filter_by_catechild_id;
		// CACHE
		$this->content = $content;
	}

	function make_query(){

		$where = "WHERE id NOT IN ({$this->content['id_collection']}) {$this->content['filter_by_cates_id']} {$this->content['filter_by_catechild_id']} LIMIT 0 ,". $this->map_limit_book['GRIDBLOCK_CATES_RECOMENDED_LOADMORE'];
		// NOW READY TO JOIN
		$query = "SELECT * FROM {$this->content['table']} $where";
		return $query;
	}

	// SHOW ITEM
	function show_time(){
		$query = $this->make_query();
		$this->template->item($query, '', $this->router, true, $this->content['suggest']);
	}
}
?>