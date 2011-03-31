<?php

class User extends AQX_Controller{

  function __construct(){
    parent::__construct();
    $this->load->model('user_model');
  }

  function login(){
    $this->status['code'] = 501;
    $this->status['message'] = 'Not Implemented';
    $this->render();
  }

  function logout(){
    if ($this->logged()){
      $this->user_model->logout();
      $this->status['message'] = 'Logged out';
    }
    $this->render();
  }

  function register(){
    $this->status['code'] = 501;
    $this->status['message'] = 'Not Implemented';
    $this->render();
  }

  function list_heroes(){
    $this->load->model('hero_model');
    $this->data['heroes'] = $this->hero_model->getHeroes($this->user_id);
    $this->render();
  }

  function list_classes(){
    $this->load->model('hero_model');
    $this->data['classes'] = $this->hero_model->getHeroClasses();
    $this->render();
  }

}

?>
