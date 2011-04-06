<?php

class Store_Model extends AQX_Extended_Model{

  protected $table_name = 'place';

  function getItems($place_id){
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

}

?>
