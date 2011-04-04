<?php 

require_once APPPATH . 'core/AQX_InGame_Controller.php';

class Place extends AQX_InGame_Controller{
  
  function __construct(){
    parent::__construct();
    $this->load->model('place_model');
    $this->town_id = $this->_getRefId();
  }

  function getPlace(){
    $place_id = $this->input->post('id');
    $data = $this->place_model->getPlace($this->town_id, $place_id);
    if (!$data){
      //404 no such place here;
      $this->setStatus(404, 'Place not found');
    } else {
      $this->addData('data', $data);  
    }
    $this->render();
  }

  function hospital(){
    $place_id = (int)$this->input->post('id');
    $data = $this->place_model->getPlace($this->town_id, $place_id);
    if(!$data){
      //404 no such place here;
      $this->setStatus(404, 'Place not found');       
    } else {
      //FIXME Two queries for one thing;
      $this->place_model->load($place_id);
      $this->addData('message', sprintf(lang('Healing costs %d'), $this->place_model->get('price', 10)));
      $this->addData('price', $this->place_model->get('price', 10));
      $this->addAction('town', lang('Back to town'));
      $this->addAction('town/hospital_heal', lang('Heal'), 'id=%d');
    }
    $this->render();
  }

  function hospital_heal(){
    
  }
 

}

?>
