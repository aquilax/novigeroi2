<?php

class Store extends AQX_InTown_Controller{
  
  private $store_type = 3;
  private $store_id = -1;

  function __construct(){
    parent::__construct();
    $this->load->model('store_model');
    $store_id = (int)$this->uri->segment(4);
    $id = $this->store_model->load(array('id' => $store_id, 
      'place_type_id' => $this->store_type));
    if (!$id){
      $this->guard();
    }
  }

  function list_items(){
    $data = $this->store_model->getItems($store_id);
    $this->addData('data', $data);
    $this->setStatus(501, 'Not Implemented');
    $this->render();     
  }

  function buy(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

  function sell(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

}

?>
