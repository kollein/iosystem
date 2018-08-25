<?php
class Adapter_cates extends Model_sqlDynamic{
	public function __construct($conn){
		$this->_conn=$conn; 
	}
}
?>