<?php

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
      $this->setStatus(400, 'Hero Class not found');
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

  function levelUp($exp){
    //TODO: These should be class specific
    $HP_C1 = 2;
    $HP_C2 = 3;
    $MP_C1 = 1.4;
    $MP_C2 = 4;
    $new_level = exp2level($exp);
    $this->set('hp_max', max_change($new_level, $HP_C1, $HP_C2));
    $this->set('mp_max',  max_change($new_level, $MP_C1, $MP_C2));
    $this->set('level', $new_level);
    //up the values to the maximum;
    $this->set('hp', $this->get('hp_max'));
    $this->set('mp', $this->get('mp_max'));
    //Don't forget the new status later;
  }

  function buy_store($place_id, $item_id){
    $select = array(
      'item_id',
      'gold1',
      'gold2',
    );
    $this->db->select($select);
    $this->db->where('place_id', $place_id);
    $this->db->where('item_id', $item_id);
    $query = $this->db->get('place_inventory');
    $item = $query->row_array();
    if (!$item){
      $this->setStatus(400, 'Item not found');
      return FALSE;
    }
    $gold1 = $this->get('gold1', 0);
    $gold2 = $this->get('gold2', 0);
    if($gold1 - $item['gold1'] < 0){
      $this->setStatus(400, 'Gold 1 not found');
      return FALSE;
    }
    if($gold2 - $item['gold2'] < 0){
      $this->setStatus(400, 'Gold 2 not found');
      return FALSE;
    }
    $data = array(
      'hero_id' => $this->get('id'),
      'item_id' => $item['item_id'],
    );
    $this->db->set($data);
    if ($this->db->insert('hero_inventory')){
      $this->set('gold1', $gold1 - $item['gold1']);
      $this->set('gold1', $gold2 - $item['gold2']);
      $this->save();
      return TRUE;
    }
    $this->setStatus(500, 'Something went wrong');
    return FALSE;
  }
}

?>
