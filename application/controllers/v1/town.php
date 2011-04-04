<?php

class Town extends AQX_InTown_Controller{

  function __construct(){
    parent::__construct();
    $this->load->model('town_model');
  }

  function getPlaces(){
    $this->addData('list', $this->town_model->getPlaces($this->town_id));
    $this->render();
  }

}

?>
