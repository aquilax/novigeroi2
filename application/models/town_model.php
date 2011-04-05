<?php

class Town_Model extends AQX_Extended_Model{

  protected $table_name = 'town';

  function getPlaces($town_id){
    $select = array(
      'p.town_id',
      'p.id AS id',
      'p.name AS name',
      'p.place_type_id',
      'pt.name AS place_type_name',
      'pt.controller',
    );
    $this->db->select($select);
    $this->db->where('p.town_id', $town_id);
    $this->db->join('place_type pt', 'pt.id = p.place_type_id');
    $query = $this->db->get('place p');
    return $query->result_array();
  }

}

?>
