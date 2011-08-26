<?php

class Town_Model extends AQX_Extended_Model{

  protected $table_name = 'town';

  //FIXME db
  function load($id) {
    $this->data = array(
      'id' => '1',
      'name' => 'Тестопополис',
      'description' => '',
    );
    return $this->data['id'];
  }  
  
  function getPlaces($town_id){
    //FIXME db
    
    return array (
      0 => 
      array (
        'town_id' => '1',
        'id' => '1',
        'name' => 'ЦУМ',
        'place_type_id' => '1',
        'place_type_name' => 'Магазин',
        'controller' => 'store/show',
      ),
      1 => 
      array (
        'town_id' => '1',
        'id' => '2',
        'name' => 'ВМА',
        'place_type_id' => '2',
        'place_type_name' => 'Лечебница',
        'controller' => 'place/hospital',
      ),
    );    
    
    
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
