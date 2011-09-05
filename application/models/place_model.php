<?php

class Place_Model extends AQX_Extended_Model{

  protected $table_name = 'place';

  
  //FIXME db
  function load ($id) {
    $this->data = array(
      'id' => 2,
      'town_id' => 1,
      'place_type_id' => 1,
      'name' => 'ВМА',
      'description' => 'Болница на края на града',
    );
    return 2;
  }
  
  function getPlace($town_id, $place_id){
    //FIXME  db
    return array(
      'town_id' => 1,
      'id' => 1,
      'place_type_id' => 1,
      'place_type_name' => 'Болница',
      'controller' => 'hospital',
      'description' => 'болница на края на града',
    );
    
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
