<?php

class Store extends AQX_InTown_Controller{
  
  private $place_type_id = 1;
  private $place_id = -1;

  function __construct(){
    parent::__construct();
    $this->load->model('store_model');
    $this->place_id = (int)$this->uri->segment(4);
    $id = $this->store_model->load(array('id' => $this->place_id, 
      'town_id' => $this->town_id,
      'place_type_id' => $this->place_type_id));
    if (!$id){
      $this->_guard();
    }
  }

  function show(){
    $this->setMain($this->store_model->get_array());
    $data = $this->store_model->getItems($this->place_id);
    foreach($data as $row){
      $this->addAction('store/buy/'.$this->place_id.'/'.$row['id'], $row['item_name']); 
    }    
    $this->addAction('town', lang('Back to town')); 
    $this->render();
  }
  
  function get_items(){
    $data = $this->store_model->getItems($this->place_id);
    $this->addData('data', $data);
    foreach($data as $row){
      $this->addAction('store/buy/'.$this->place_id.'/'.$row['id'], $row['item_name']); 
    }
    $this->render();     
  }

  function buy(){
    $item_id = (int)$this->uri->segment(5);
    $this->store_model->buyItem($this->place_id, $item_id);
    $this->render();
  }

  function sell(){
    $inventory_id = (int)$this->uri->segment(5);
    $store_margin = (float)$this->store_model->get('margin', .8);
    $this->store_model->sellItem($store_margin, $inventory_id);
    $this->render();
  }

}

?>
