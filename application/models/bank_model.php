<?php

class Bank_Model extends AQX_Extended_Model{
  
  protected $table_name = 'place';

  function getTransactions($place_id, $hero_id, $all = TRUE, $limit = 100){
    $select = array(
      'p.name',
      'bt.gold1',
      'bt.created',
      'bt.operation_type_id',
      'ot.name AS operation_name',
    );
    $this->db->select($select);
    $this->db->join('place p', 'p.id = bt.place_id');
    $this->db->join('operation_type ot', 'bt.operation_type_id = ot.id');
    if (!$all){
      $this->db->where('bt.place_id', $place_id);
    }
    $this->db->where('bt.hero_id', $hero_id);
    $this->db->order_by('bt.created', 'DESC');
    $this->db->limit($limit);
    $query = $this->db->get('bank_transaction bt');
    return $query->result_array();
  }

}

?>
