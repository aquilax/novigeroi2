<?php

class AQX_Model extends CI_Model{

  protected $key_name = 'id';
  public $status = array('code' => 200, 'message' => 'OK');

  function __construct(){
    parent::__construct();  
  }

  function _getRow($id, $table){
    $this->db->where('id', $id);
    $this->db->limit(1);
    $query = $this->db->get($table);
    return $query->row_array();
  }

  function _debug($text = FALSE){
    $text = ($text)?$text:$this->db->last_query();
    die($text);
  }

}

?>
