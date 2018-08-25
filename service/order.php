<?php
class Adapter_order extends Model_sqlDynamic{

	protected $_map_go_view;

	public function __construct($conn){
		global $map_go_view;
		$this->_conn = $conn;
		$this->_map_go_view = $map_go_view;
	}
	// GET DATA FROM CART DATA JSON
	function get_data_from_cart_data_json($cart_data_json){
		// ASSIGN FOR EASY CONTACT
		$content = $cart_data_json;
		// DATA RETURN: DEFAULT
		$data_return = null;
		// CHECK : @content MUST IS ARRAY
		if ( is_array($content) ) {
		    // NOW WE NEED COLLECTION ITEM BY BOOK_CASE FOR ONE QUERY TO MYSQL
		    // WE NEED A QUERY CHECK ALL FOR FETCH
		    $query_check_all = ['s' => false, 't' => false, 'p' => false];
		    // COLLECTION COLUMNS SAME BETWEEN DIFFERENT TABLES (UPPERCASE IMPORTANT)
		    $collection_same_column = 'ID, TITLE, IMAGE, PRICE';
		    // QUERY HEADER: YES OR NO
		    $query_header = "";
		    // BOOK_CASE: s
		    $collection_id_by_s = collection_id_by_book_case($content, 's');
		    if( count($collection_id_by_s) > 0 ){
		        $str_collection_id = implode(',', $collection_id_by_s);
		        $query_s = "SELECT $collection_same_column, if(ID = 0, 'SHARE', 'SHARE') AS 'BOOK_CASE' FROM BOOK_SHARE WHERE id IN ($str_collection_id)";
		        $query_check_all['s']  = true;
		    }
		    // BOOK_CASE: t
		    $collection_id_by_t = collection_id_by_book_case($content, 't');
		    if( count($collection_id_by_t) > 0 ){
		        $str_collection_id = implode(',', $collection_id_by_t);
		        /*
				BECAUSE, QUERY IS MULTI-TABLE UNION
				WE NEED CHECK TO MAKE QUERY BE VALID
		        */
		        if( $query_check_all['s'] ){
		        	$query_header = " UNION";
		        }
		        $query_t = " $query_header SELECT $collection_same_column, if(ID = 0, 'TRADITIONAL', 'TRADITIONAL') AS 'BOOK_CASE' FROM BOOK_TRADITIONAL WHERE id IN ($str_collection_id)";
		        $query_check_all['t']  = true;
		    }
		    // BOOK_CASE: p
		    $collection_id_by_p = collection_id_by_book_case($content, 'p');
		    if( count($collection_id_by_p) > 0 ){
		        $str_collection_id = implode(',', $collection_id_by_p);
		        /*
				BECAUSE, QUERY IS MULTI-TABLE UNION
				WE NEED CHECK TO MAKE QUERY BE VALID
		        */
		        if( $query_check_all['t'] ){
		        	$query_header = " UNION";
		        }
		        $query_p = " $query_header SELECT $collection_same_column, if(ID = 0, 'PRODUCT', 'PRODUCT') AS 'BOOK_CASE' FROM BOOK_PRODUCT WHERE id IN ($str_collection_id)";
		        $query_check_all['p']  = true;
		    }
		    // CHECK QUERY ALL
		    if( in_array('true', $query_check_all) ){
		        // SHOW FULL ALL ITEM ADDED
		        // MERGE QUERIES
		        $query = $query_s.$query_t.$query_p;
		        // FETCH FROM MYSQL NOW
		        $this->selectQuery($query);
		        $data_fetched = $this->_rendata;
		        // FINAL: CALC
		        if( $data_fetched ){
		        	$data_return = $data_fetched;
		        }
		    }
		}

		return $data_return;
	}
	// CALC SUMMARY_CASH PER ORDER
	function calc_summary_cash_per_order($cart_data_json){
		$data_fetched = $this->get_data_from_cart_data_json($cart_data_json);
		$sumary_cash = 0;
		if( $data_fetched ){
			foreach( $data_fetched as $row ){
	            $bookcase_lower_alias = strtolower( substr( $row['BOOK_CASE'], 0, 1 ) );
	            $mixed_id = $bookcase_lower_alias.'_'.$row['ID'];
	            $item_amount = $cart_data_json[$mixed_id][0]['amount'];
	            $sumary_cash += $row['PRICE'] * $item_amount;
	        }
	    }
        return $sumary_cash;
	}
	// GET DATA WHERE ALL ORDER HAS EXCHANGE SUCCESS
	function get_data_where_all_order_has_exchanged($user_id, $exchange_status){
		// DATA RETURN: DEFAULT
		$data_return = null;
		// ASSIGN EXCHANGE_STATUS IN CONDITION
		if( $exchange_status === 1 ){
			$exchange_status_condition_str = "AND exchange_status = $exchange_status";
		}elseif( $exchange_status === 0 ){
			$exchange_status_condition_str = "AND exchange_status = $exchange_status";
		}else{
			// FETCH BOTH
			$exchange_status_condition_str = '';
		}
		// WHERE: exchange_status = 1 (SUCCESS) , 0 (NO-EXCHANGE)
		$where = "WHERE user_id = $user_id $exchange_status_condition_str";
		$this->selectRow(ORDER_STORE, $where);
		$data_fetched = $this->_rendata;
		if( $data_fetched ){
			$data_return = $data_fetched;
		}
		return $data_return;
	}
	// CALC SUMMARY_LSD GOT BY ALL EXCHANGE SUCCESS ORDER
	function calc_summary_lsd_got_by_all_exchange_order($user_id, $exchange_status){
		$data_fetched = $this->get_data_where_all_order_has_exchanged($user_id, $exchange_status);
		$summary_lsd = 0;
		if( $data_fetched ){
			foreach( $data_fetched as $row ){
				$summary_lsd += $row['GET_LSD'];
			}
		}
		return $summary_lsd;
	}
	// CALC SUMMARY_LSD USED BY ALL EXCHANGE ORDER: INCLUDE: SUCCESS AND WAITING
	/*
	WHY CALC BOTH: SUCCESS AND WAITING
	BECAUSE, WHEN DRIVER EXCHANGING OUTSIDE OF SYSTEM IN DIFFERRENT TIME
	*/
	function calc_summary_lsd_used_by_all_exchange_order($user_id, $exchange_status){
		$data_fetched = $this->get_data_where_all_order_has_exchanged($user_id, $exchange_status);
		$summary_lsd = 0;
		if( $data_fetched ){
			foreach( $data_fetched as $row ){
				$summary_lsd += $row['USE_LSD'];
			}
		}
		return $summary_lsd;
	}
	// CONVERT STRING STRUCTURED ORDER CART TO ARRAY
	function convert_str_structured_cart_to_arr($str){
		$stack_data_item = explode('|', $str);
		$id_cached = '';
		// INIT: EMPTY MIX, OBJECT
		$inner_mix = [];
		$inner_obj = new stdClass;
		foreach( $stack_data_item as $k => $v ){
			$stack_per_stack = explode('=', $v);
			if( $k == 0 ){
				$id_cached = $stack_per_stack[1];
			}
			$inner_obj->$stack_per_stack[0] = $stack_per_stack[1];
		}
		array_push($inner_mix, $inner_obj);
		// INIT: EMPTY ARRAY TO OBJECT
		$output_mix = new stdClass;
		$output_mix->$id_cached = $inner_mix;
		return $output_mix;
	}
	// GENERATE MAP : [ALIAS, ID] FROM CART ITEM ID
	function generate_map_cart_item_id($alias_id_str){
	    $stack = explode('_', $alias_id_str, 2);
	    return ['alias' => $stack[0], 'id' => $stack[1]];
	}
	// FIND ROW ITEM BR MAP ALIAS ID
	function find_row_item_by_map_alias_id($rowBOOK_s, $map_alias_id){
	    $row = null;
	    foreach( $rowBOOK_s as $row ){
	    	$TABLE = "BOOK_".$row['BOOK_CASE'];
	        if( $row['ID'] == $map_alias_id['id'] && $this->_map_go_view[$TABLE] ){
	            break;
	        }
	    }
	    return $row;
	}
}
?>