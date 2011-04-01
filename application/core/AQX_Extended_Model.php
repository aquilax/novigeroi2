<?php

class AQX_Extended_Model extends AQX_Model{

  protected $data_key = '_data';
  protected $data = array();
  protected $in_data = array();
  private $update = array();

  private function loadJSON($text){
    $res = json_decode($text, TRUE);
    if ($res === null ) $res = array();
    return $res;
  }

  public function load($id){
    $this->data = $this->_getRow($id, $this->table_name);
    if ($this->data){
      if (isset($this->data[$this->data_key])){
        $this->in_data = $this->loadJSON($this->data[$this->data_key]); 
        unset($this->data[$this->data_key]);
      }
      return TRUE;
    }
    return FALSE;
  }

  public function get($key, $default = FALSE){
    if (isset($this->data[$key])){
      return $this->data[$key];
    }
    if (isset($this->in_data[$key])){
      return $this->in_data[$key];
    }
    return $default;
  }

  public function set($key, $value){
    $old_val = $this->get($key);
    if ($old_val === FALSE || $old_val != $value){ // If new column or changed data then add to update
      $this->update[$key] = $value;
    }
  }
  
  public function save(){
    if (count($this->update)){
      $data = array();
      $json = array();
      foreach($this->update as $key => $val){
        if (isset($this->data[$key])){
          $data[$key] = $val;
        } else {
          $json[$key] = $val;
        }
      }
      if ($json){
        $data[$this->data_key] = array_merge($this->in_data, $json);
      }

      $this->db->where('id', $id);
      $this->db->set($data);
      $this->db->update($this->table_name);
      return TRUE; //updated
    }
    return FALSE; //nothing to update
  }

}

?>
