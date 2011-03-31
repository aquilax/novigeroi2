<?php

//this is ugly but I don't know ho to have multiple inheritance in CI;
require_once APPPATH.'/models/base_char_model.php';

class Hero_model extends Base_char_Model{

  private $table_name = 'hero'; //hero's table;

  //List all heroes for user
  public function getHeroes($user_id){
    $this->db->where('user_id', $user_id);
    $this->db->order_by('created');
    $query = $this->db->get($this->table_name);
    return $query->result_array();
  }

  //Create new hero;
  public function createHero($user_id, $name, $class_id){
    //Will keep all template heroes in the table with owner user_id 0;
    $this->where('user_id', 0);
    $this->where('class', $class_id);
    $this->db->limit(1);
    $query = $this->db->get($this->table_name);
    $data = $query->row_array();
    if (!$data){
      //Class Template not found;
      return FALSE;  
    }
    
    unset($data[$this->key]);
    $data['name'] = $name;
    $data['user_id'] = $user_id; //override the user_id
    $this->db->set($data); //set the template data;
    $this->db->set('created', 'CURRENT_TIMESTAMP', FALSE);  //set the current timestamp for creation;
    $this->db->insert($this->table_name);
    return $this->db->insert_id();
  }

  function getHeroClasses(){
    $select = array(
      'id',
      'name',
    );
    $this->db->select($select);
    $this->where('user_id', 0);
    $this->where('class', $class_id);
    $this->db->order_by('created');
    $query = $this->db->get($this->table_name);
    return $query->return_array();
  }

}

?>
