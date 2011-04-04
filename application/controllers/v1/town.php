<?php

require_once APPPATH . 'core/AQX_InGame_Controller.php';

class Town extends AQX_InGame_Controller{

  private $town_id = 0;

  function __construct(){
    parent::__construct();
    $this->load->model('town_model');
    $this->town_id = $this->_getRefId();
  }

  function _getTownId(){
    //FIXME: get current town here from hero's reff_id
    return 1;
  }

  function getPlaces(){
    $this->addData('list', $this->town_model->getPlaces($this->town_id));
    $this->render();
  }


}

?>
