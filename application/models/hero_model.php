<?php

//this is ugly but I don't know ho to have multiple inheritance in CI;
require_once APPPATH.'/models/base_char_model.php';

class Hero_model extends Base_char_Model{

  private $table_name = 'hero'; //hero's table;

}

?>
