<?php

require_once APPPATH . 'core/AQX_Logged_Controller.php';

class User extends AQX_Logged_Controller{

  function getHeroes(){
    $this->load->model('hero_model');
    $this->addData('heroes', $this->hero_model->getHeroes($this->user_id));
    $this->render();
  }

  function getClasses(){
    $this->load->model('hero_model');
    $this->addData('classes', $this->hero_model->getHeroClasses());
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
        $this->addData('id', $id);
      } else {
        $this->setStatus(
          $this->hero_model->status['code'], 
          $this->hero_model->status['message']
        );
      }
    } else {
      $this->setStatus(400, validation_errors('', "\n"));
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
