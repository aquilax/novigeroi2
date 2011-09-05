<?php

class Store_Model extends AQX_Extended_Model{

  protected $table_name = 'place';

  //FIXME db
  function load($id) {
    $this->data = array(
      'id' => 1,
      'town_id' => 1,
      'place_type_id' => 1,
      'name' => 'ЦУМ',
      'description' => 'Всичко за всеки'
    );
    return 1;
  }
  
  function getItems($place_id){
    //FIXME: db
    return array(array(
        'item_type_id' => 1,
        'item_type_name' => 'тояга',
        'id' => 1,
        'item_name' => 'Дълга тояга',
    ));
    
    
    $select = array(
      'item_type_id',
      'it.name AS item_type_name',
      'i.id AS id',
      'i.name AS item_name',
    );
    $this->db->select($select);
    $this->db->join('item i', 'pi.item_id = i.id');
    $this->db->join('item_type it', 'it.id = i.item_type_id');
    $this->db->where('pi.place_id', $place_id);
    $this->db->order_by('i.item_type_id, mod1_val, mod2_val');
    $query = $this->db->get('place_inventory pi');
    return $query->result_array();
  }  

  function buyItem($place_id, $item_id){
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

  function sellItem($margin, $inventory_id){
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
