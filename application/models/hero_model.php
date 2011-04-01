<?php

require_once APPPATH.'core/AQX_Extended_Model.php';

class Hero_model extends AQX_Extended_Model{

  protected $table_name = 'hero'; //hero's table;

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
    $this->db->where('user_id', 0);
    $this->db->where('id', $class_id);
    $this->db->limit(1);
    $query = $this->db->get($this->table_name);
    $data = $query->row_array();
    if (!$data){
      //Class Template not found;
      $this->status['code'] = 400;
      $this->status['message'] = 'Hero Class not found';
      return FALSE;  
    } 
    unset($data[$this->key_name]);
    $data['name'] = $name;
    $data['class_id'] = $class_id;
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
    $this->db->where('user_id', 0);
    $this->db->order_by('created');
    $query = $this->db->get($this->table_name);
    return $query->result_array();
  }

}

?>
