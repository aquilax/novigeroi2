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

  function inventory(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

  function equip(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

  function unequip(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

  function use(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

  function drop(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

}

?>
