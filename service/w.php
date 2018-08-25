<?php
class Adapter_w extends Model_sqlDynamic{
	public function __construct($conn){
		$this->_conn=$conn;
	}
}
?>