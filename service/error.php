<?php
class Adapter_error extends Model_sqlDynamic{
	public function __construct($conn){
		$this->_conn = $conn;
	}
}
?>