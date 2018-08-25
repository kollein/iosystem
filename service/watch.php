<?php
class Adapter_watch extends Model_sqlDynamic{
	public function __construct($conn){
		$this->_conn = $conn; 
	}
}
?>