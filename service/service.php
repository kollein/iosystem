<?php
// THIS IS USER: NOT BOOK_CASE
class Adapter_service extends Model_sqlDynamic{
	public function __construct($conn){
		$this->_conn=$conn;
	}
}
?>