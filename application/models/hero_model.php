<?php

class Hero_model extends AQX_Extended_Model{

  protected $table_name = 'hero'; //hero's table;

  //FIXME db
  function load(){
    $this->data = $this->session->userdata($this->table_name);
    if (!$this->data) {
      $this->data = array(
        'id' => 1,
        'user_id' => 1,
        'class_id' => 1,
        'name' => 'цецо',
        'exp' => '3',
        'last_online' => 0,
        'level' => 1,
        'status' => 'fight',
        'status_ref_id' => 1,
        'gold1' => 200,
        'map_id' => 1,
        'map_x' => 1,
        'map_y' => 1,
        'hp' => 30,
        'defence' => 2,
        'attack' => 2,
      );
      return 1;
    }
    return $this->data['id'];
  }
  
  //FIXME db
  function save(){
    $this->session->set_userdata($this->table_name, $this->data);
  }
  
  
  //List all heroes for user
  public function getHeroes($user_id){
    //FIXME db
    return array (
      0 => 
      array (
        'id' => '2',
        'user_id' => '1',
        'class_id' => '1',
        'name' => '123',
        'level' => '1',
        'exp' => '1',
        'created' => '2011-04-01 07:15:19',
        'last_online' => '0000-00-00 00:00:00',
        'status' => 'town',
        'status_ref_id' => '1',
        'map_id' => '1',
        'map_x' => '0',
        'map_y' => '0',
        '_data' => '{}',
      ),
      1 => 
      array (
        'id' => '3',
        'user_id' => '1',
        'class_id' => '1',
        'name' => 'цуцо',
        'level' => '1',
        'exp' => '1',
        'created' => '2011-04-03 07:11:27',
        'last_online' => '0000-00-00 00:00:00',
        'status' => 'home',
        'status_ref_id' => NULL,
        'map_id' => '1',
        'map_x' => '0',
        'map_y' => '0',
        '_data' => '{}',
      ),
    );
    
    
    
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
    //FIXME db
    return array (
      0 => 
      array (
        'id' => '1',
        'name' => 'Варварин',
      ),
    );
        
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
      $this->setStatus(404, 'Item not found');
      return FALSE;
    }
    return $this->_buy($item);
  }

  function _buy($item){
    $gold1 = $this->get('gold1', 0);
    $gold2 = $this->get('gold2', 0);
    if($gold1 - $item['gold1'] < 0){
      $this->setStatus(404, 'Gold 1 not found');
      return FALSE;
    }
    if($gold2 - $item['gold2'] < 0){
      $this->setStatus(404, 'Gold 2 not found');
      return FALSE;
    }
    $data = array(
      'hero_id' => $this->get('id'),
      'item_id' => $item['item_id'],
      'gold1' => $item['gold1'],
      'gold2' => $item['gold2'],
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

  function sell_store($margin, $inventory_id){
    $select = array(
      'id',
      'gold1',
      'gold2',
    );
    $this->db->select($select);
    $this->db->where('hero_id', $this->get('id'));
    $this->db->where('id', $inventory_id);
    $this->db->where('status', 0); //sell only unequipped items
    $query = $this->db->get('hero_inventory');
    $item = $query->row_array();
    if (!$item){
      $this->setStatus(404, 'Item not found');
      return FALSE;
    }
    return $this->_sell($item, $margin);
  }

  function _sell($item, $margin){
    $gold1 = $this->get('gold1', 0);
    $gold2 = $this->get('gold2', 0);
    $item_gold_1 = nlt((int)($item['gold1']*$margin), 1);
    $item_gold_2 = 0; // no money back :)
    $data = array(
      'hero_id' => $this->get('id'),
      'id' => $item['id'],
    );
    $this->db->where($data);
    if ($this->db->delete('hero_inventory')){
      $this->set('gold1', $gold1 + $item_gold_1);
      $this->save();
      return TRUE;
    }
    $this->setStatus(500, 'Something went wrong');
    return FALSE;
  }

}

?>
