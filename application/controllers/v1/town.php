<?php

require_once APPPATH . 'core/AQX_InGame_Controller.php';

class Town extends AQX_InGame_Controller{

  private $town_id = 0;

  function __construct(){
    parent::__construct();
    $this->load->model('town_model');
    //TODO: get current town here from hero's reff_id
  }

  function getPlaces(){
    $this->setData('list', $this->town_model->getPlaces($this->town_id));
    $this->render();
  }

  function getPlace(){
    $place_id = $this->input->post('id');
    $data = $this->town_model->getPlace($this->town_id, $place_id);
    if (!$data){
      //404 no such place here;
      $this->setStatus(404, 'Place not found');
    } else {
      $this->setData('data', $data);  
    }
    $this->render();
  }

}

?>
