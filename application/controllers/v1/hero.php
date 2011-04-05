<?php

class Hero extends AQX_InGame_Controller{
  
  function __construct(){
    parent::__construct();
    $this->load->model('hero_model');
    $this->hero_model->load(array('id' => $this->hero_id));
  }

  function info(){
    $this->addData('name', $this->hero_model->get('name'));
    $this->addData('hp', $this->hero_model->get('hp', 0));
    $this->addData('hp_max', $this->hero_model->get('hp_max', 0));
    $this->addData('mp', $this->hero_model->get('mp', 0));
    $this->addData('mp', $this->hero_model->get('mp_max', 0));
    $this->addData('x', $this->hero_model->get('x', -1));
    $this->addData('y', $this->hero_model->get('y', -1));
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

  function use_item(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

  function drop_item(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

}

?>
