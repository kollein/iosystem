<?php
class Model_Cache_gdata{

	protected $_mainRi;

	public function __construct($mainRi){
		// ASSIGN:
		$this->_mainRi = $mainRi;
	}

	function collect_id_item_from_user_cache_by_book_case_alias($user_id, $book_case_alias, $number_item){
		// GET VIEW ITEM HISTORY
		$query_user_cache = "SELECT * FROM USER_CACHE WHERE user_id = $user_id";
		$this->_mainRi->selectQuery($query_user_cache);
		$rowUSER_CACHE = $this->_mainRi->_rendata[0];
		$content = json_decode($rowUSER_CACHE['VIEW_ITEM_HISTORY'], true);
		// JOIN STRING
		$id_collection_str = implode( ',', array_slice( collection_id_by_book_case($content, $book_case_alias), 0, $number_item, true ) );
		$id_collection_str = $id_collection_str ? $id_collection_str : '0';
		return $id_collection_str;
	}
}
?>