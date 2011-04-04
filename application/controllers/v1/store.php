<?php

require_once APPPATH . 'core/AQX_InTown_Controller.php';

class Store extends AQX_InTown_Controller{
  
  private $store_type = 3;

  function __construct(){
    parent::__construct();
    $this->load->model('store_model');
  }

  function list_items(){
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
