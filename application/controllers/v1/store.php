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
    $this->setData($this->store_model->get_array());
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
    $this->hero_model->buy_store($this->place_id, $item_id);
    $this->setStatus($this->hero_model->status['code'],
      $this->hero_model->status['message']);
    $this->render();
  }

  function sell(){
    $inventory_id = (int)$this->uri->segment(5);
    $store_margin = (float)$this->store_model->get('margin', .8);
    $this->hero_model->sell_store($store_margin, $inventory_id);
    $this->setStatus($this->hero_model->status['code'],
      $this->hero_model->status['message']);
    $this->render();
  }

}

?>
