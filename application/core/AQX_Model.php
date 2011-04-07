<?php

class AQX_Model extends CI_Model{

  protected $key_name = 'id';
  public $status = array('code' => 200, 'message' => 'OK');

  function __construct(){
    parent::__construct();  
  }

  function _getRow($filter, $table){
    $this->db->where($filter);
    $this->db->limit(1);
    $query = $this->db->get($table);
    return $query->row_array();
  }

  function _debug($text = FALSE){
    $text = ($text)?$text:$this->db->last_query();
    die($text);
  }

}


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

  public function load($filter){
    $this->data = $this->_getRow($filter, $this->table_name);
    if ($this->data){
      //TODO: Lazy parse the JSON data
      if (isset($this->data[$this->data_key])){
        $this->in_data = $this->loadJSON($this->data[$this->data_key]); 
        unset($this->data[$this->data_key]);
      }
      return $this->data[$this->key_name];
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
    //FIXME should also change the original value for next gets
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

      $this->db->where($this->key_name, $this->data[$this->key_name]);
      $this->db->set($data);
      $this->db->update($this->table_name);
      $this->update = array();
      return TRUE; //updated
    }
    return FALSE; //nothing to update
  }

  function setStatus($code, $message){
    $this->status['code'] = $code;
    $this->status['message'] = $message;
  }

}
?>
