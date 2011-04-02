<?php

require_once APPPATH . 'core/AQX_Public_Controller.php';

class Auth extends AQX_Public_Controller{

  function __construct(){
    parent::__construct();
    $this->load->model('user_model');
  }

  function login(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }

  function logout(){
    $this->user_model->logout();
    $this->setStatus(200, 'Logged out');
    $this->render();
  }

  function register(){
    $this->setStatus(501, 'Not Implemented');
    $this->render();
  }


}

?>
