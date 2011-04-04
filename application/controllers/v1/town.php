<?php

require_once APPPATH . 'core/AQX_InTown_Controller.php';

class Town extends AQX_InTown_Controller{

  function getPlaces(){
    $this->addData('list', $this->town_model->getPlaces($this->town_id));
    $this->render();
  }

}

?>
