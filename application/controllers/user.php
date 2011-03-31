<?php

class User extends AQX_Controller{

  function __construct(){
    parent::__construct();
    $this->load->model('user_model');
  }

  function login(){
    //
  }

  function logout(){
    if ($this->logged()){
      $this->user_model->logout();
      $this->status = 200;
      $this->message = 'Logged out';
    }
    $this->render();
  }

  function register(){
    //
  }

  function list_heroes(){
    $this->load->model('hero_model');
    $this->data['heroes'] = $this->hero_model->listHeroes($this->user_id);
    $this->render();
  }

}

?>
