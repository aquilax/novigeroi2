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
  protected $db_keys = array();
  protected $json_keys = array();
  private $update = array();

  private function loadJSON($text){
    $res = json_decode($text, TRUE);
    if ($res === null ) $res = array();
    return $res;
  }

  public function load($filter){
    $all = $this->_getRow($filter, $this->table_name);
    $json = array();
    if ($all){
      if (isset($all[$this->data_key])){
        $json = $this->loadJSON($all[$this->data_key]); 
        unset($all[$this->data_key]);
      }
      $this->data = array_merge($json, $all);
      
      //Get the keys
      $this->db_keys = array_keys($all);
      unset($all);
      $this->json_keys = array_keys($json);
      unset($json);
      
      return $this->data[$this->key_name];
    }
    return FALSE;
  }

  public function get($key, $default = FALSE){
    if (isset($this->data[$key])){
      return $this->data[$key];
    }
    return $default;
  }

  public function get_array(){
    return $this->data;  
  }

  public function set_array($data){
    foreach($data as $name => $val){
      $this->set($name, $val);  
    }
  }

  public function set($key, $value){
    $old_val = $this->get($key);
    if ($old_val === FALSE || $old_val != $value){ // If new column or changed data then add to update
      $this->data[$key] = $value;
      $this->update[$key] = $value;
    }
  }
  
  public function save(){
    if (count($this->update)){
      $data = array();
      $json = array();
      foreach($this->update as $key => $val){
        if (in_array($key, $this->db_keys)){
          $data[$key] = $val;
        } else {
          $json[$key] = $val;
        }
      }
      if ($json){
        $ja = array();
        foreach($this->json_keys as $name){
          $ja[$name] = $this->get($name);
        }
        //The merge here is not really necessary;
        $data[$this->data_key] = json_encode(array_merge($ja, $json));
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
