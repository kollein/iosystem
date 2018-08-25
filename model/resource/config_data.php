<?php
class Model_Resource_config_data{

	public $mainRi;
    public $map_go_view;
    public $map_limit_book;
    public $TABLE;
    public $user_data;

	function __construct(){

		global $mainRi, $map_go_view, $map_limit_book, $TABLE, $user_data;
		// ASSIGN:
		$this->mainRi = $mainRi;
		$this->map_go_view = $map_go_view;
		$this->map_limit_book = $map_limit_book;
		$this->TABLE = $TABLE;
		$this->user_data = $user_data;
	}
}
?>