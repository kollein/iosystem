<?php
class Adapter_feed extends Model_sqlDynamic{
 public function __construct($conn){
  $this->_conn=$conn;
 }

}

 ?>