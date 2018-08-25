<?php
class Adapter_search extends Model_sqlDynamic{
	public function __construct($conn){
		$this->_conn=$conn;
	}

	function make_underscore_key_search($key_search){
		$key_search_underscore = '';
		$stack_key_search = explode(' ', $key_search);
		foreach( $stack_key_search as $word ){
			$word_lenght = strlen($word);
			$first_char = substr($word, 0, 1);
			$last_char = substr($word, -1);
			// JOIN
			$word_underscore = $first_char.str_repeat('_', $word_lenght - 2).$last_char;
			$key_search_underscore .= $word_underscore.' ';
		}
		return trim($key_search_underscore);
	}
	function get_search_result_data($key_search, $map_table_in_search, $extra_where = ''){
		$data_return = [];
		// STACK KEY SEARCH
		$stack_key_search = explode(' ', $key_search);
		// FIRST WORD
		$stack_key_search_first = $stack_key_search[0] != null ? $stack_key_search[0] : 'ZZZ_NO_ZZZ';
		// LAST WORD
		$stack_key_search_last = end($stack_key_search) != null ? end($stack_key_search) : 'ZZZ_NO_ZZZ';
		// TRUONG HOP GO SAI CHINH TA: TA SU DUNG UNDERSCORE
		$key_search_underscore = $this->make_underscore_key_search($key_search);
		// WHERE IN MANY CASE BY STACK: SAME COLUMN IN EVERY TABLE
		$where = "WHERE 
		title LIKE '%$key_search%' OR 
		title LIKE '%$stack_key_search_first%' OR 
		title LIKE '%$stack_key_search_last%' OR 
		tag LIKE '%$key_search%' OR 
		tag LIKE '%$stack_key_search_first%' OR 
		tag LIKE '%$stack_key_search_last%' OR 
		description LIKE '%$key_search%' OR 
		title LIKE '%$key_search_underscore%' OR 
		tag LIKE '%$key_search_underscore%' 
		";
		// CHECK LIMIT
		if( $extra_where > 0 ){
			$where .= " $extra_where";
		}
		/*
			MAP TABLE WITH BOOK CASE
			QUERY MULTI-TABLE
		*/
		$same_column_name = 'ID, TITLE, IMAGE, DESCRIPTION, VIEW, TAG';
		$map_table_with_book_case['TRADITIONAL'] = "
		SELECT $same_column_name, PRICE AS 'MIX_1', if(ID = 0, 'TRADITIONAL', 'TRADITIONAL') AS 'BOOK_CASE' FROM BOOK_TRADITIONAL AS t {$where}";

		$map_table_with_book_case['PRODUCT'] = "
		SELECT $same_column_name, PRICE AS 'MIX_1', if(ID = 0, 'PRODUCT', 'PRODUCT') AS 'BOOK_CASE' FROM BOOK_PRODUCT AS p {$where}";

		$map_table_with_book_case['SHARE'] = "
		SELECT $same_column_name, PRICE AS 'MIX_1', if(ID = 0, 'SHARE', 'SHARE') AS 'BOOK_CASE' FROM BOOK_SHARE AS s {$where}";

		$map_table_with_book_case['INFO'] = "
		SELECT $same_column_name, AUTHOR AS 'MIX_1', if(ID = 0, 'INFO', 'INFO') AS 'BOOK_CASE' FROM BOOK_INFO AS i {$where}";

		$map_table_with_book_case['WHERE'] = "
		SELECT $same_column_name, CHECKIN_PER_YEAR AS 'MIX_1', if(ID = 0, 'WHERE', 'WHERE') AS 'BOOK_CASE' FROM BOOK_WHERE AS w {$where}";
		// JOIN QUERY
		$query = '';
		$i = 0;
		foreach( $map_table_in_search as $v ){
			if( $i == 0 ){
				$union = "";
			}else{
				$union = "UNION ";
			}
			// JOIN HERE
			$query .= $union . $map_table_with_book_case[$v] ." ";
			$i++;

		}
		// QUERY NOW
		$this->selectQuery($query);
		if( $this->_rendata ){
			$data_return = $this->_rendata;
		}
		return $data_return;
	}

	function get_all_tag_data($map_table_in_search){
		$data_return = [];
		/*
			MAP TABLE WITH BOOK CASE
			QUERY MULTI-TABLE
		*/
		// JOIN QUERY
		$query = '';
		$i = 0;
		foreach( $map_table_in_search as $table ){
			if( $i == 0 ){
				$union = "";
			}else{
				$union = "UNION ";
			}
			// TABLE NAME
			$table_name = "BOOK_$table";
			// JOIN HERE
			$query .= $union ."SELECT DISTINCT tag FROM $table_name ";
			$i++;

		}
		// QUERY NOW
		$this->selectQuery($query);
		if( $this->_rendata ){
			$data_return = $this->_rendata;
		}
		return $data_return;
	}
}
 ?>