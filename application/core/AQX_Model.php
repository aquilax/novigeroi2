<?php

class AQX_Model extends CI_Model{

  function __construct(){
    parent::__construct();  
  }

  function _getRow($id, $table){
    $this->db->where('id', $id);
    $this->db->limit(1);
    $query = $this->db->get($table);
    return $query->row_array();
  }

}

?>
