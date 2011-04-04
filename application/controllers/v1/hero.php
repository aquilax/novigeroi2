<?php

class Hero extends AQX_InGame_Controller{
  
  function __construct(){
    parent::__construct();
    $this->load->model('hero_model');
    $this->hero_model->load($this->hero_id);
  }

  function getInfo(){
    $this->addData('name', $this->hero_model->get('name'));
    $this->addData('hp', $this->hero_model->get('hp'));
    $this->render();
  }

}

?>
