<?php
class Adapter_p extends Model_sqlDynamic{
	public function __construct($conn){
		$this->_conn=$conn;
	}
}
?>