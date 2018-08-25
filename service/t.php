<?php
class Adapter_t extends Model_sqlDynamic{
	public function __construct($conn){
		$this->_conn=$conn;
	}
}
?>