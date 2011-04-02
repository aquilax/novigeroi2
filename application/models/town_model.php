<?php

require_once APPPATH.'core/AQX_Extended_Model.php';

class Town_model extends AQX_Extended_Model{

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

  function getPlace($town_id, $place_id){
    $select = array(
      'p.town_id',
      'p.id AS id',
      'p.name AS name',
      'p.place_type_id',
      'pt.name AS place_type_name',
      'pt.controller',
      'p.description',
    );
    $this->db->select($select);
    $this->db->where('p.id', $place_id);
    $this->db->where('p.town_id', $town_id);
    $this->db->join('place_type pt', 'pt.id = p.place_type_id');
    $query = $this->db->get('place p');
    return $query->row_array();
  }
}

?>
