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

  function getHeroes(){
    $this->load->model('hero_model');
    $this->data['heroes'] = $this->hero_model->getHeroes($this->user_id);
    $this->render();
  }

  function getClasses(){
    $this->load->model('hero_model');
    $this->data['classes'] = $this->hero_model->getHeroClasses();
    $this->render();
  }

  function createHero(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'name', 'trim|xss_clean|required|callback__name_check');
    $this->form_validation->set_rules('class_id', 'class', 'trim|required|is_natural_no_zero|callback__class_check');
    if ($this->form_validation->run()){
      $name = $this->input->post('name');
      $class_id = (int)$this->input->post('class_id');
      $this->load->model('hero_model');
      $id = $this->hero_model->createHero($this->user_id, $name, $class_id);
      if ($id){
        $this->data['data'] = array('id' => $id);
      } else {
        $this->status = $this->hero_model->status;  
      }
    } else {
      $this->status['code'] = 400;
      $this->status['message'] = validation_errors('', "\n");
    }
    $this->render();
  }

  function _name_check($str){
    //TODO Name validation here; 
  }

  function _class_check($str){
    //TODO Class validation here; 
  }


}

?>
