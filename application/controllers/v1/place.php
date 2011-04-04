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
    $place_id = (int)$this->input->post('id');
    $data = $this->place_model->getPlace($this->town_id, $place_id);
    if(!$data){
      //404 no such place here;
      $this->setStatus(404, 'Place not found');       
    } else {
      if ($this->hero_model->get('HP') == $this->hero_model->get('HP_max')
        && $this->hero_model->get('MP') == $this->hero_model->get('MP_max')) {
        $this->addData('message', lang('No need to heal'));
      } else {
        $this->place_model->load($place_id);
        $price = $this->place_model->get('price', 10); //default to 10 GOLD;
        if ($this->hero_model->get('gold', 0) - $price < 0){
          $this->addData('message', lang('You don\'t have enaugh money to heal'));  
        } else {
          //All looks fine now;
          $this->hero_model->set('HP', $this->hero_model->get('HP_max'));
          $this->hero_model->set('MP', $this->hero_model->get('MP_max'));
          $this->hero_model->set('gold', $this->hero_model->get('gold')-$price);
          $this->hero_model->save();
          $this->addData('message', lang('Healed'));
          $this->addAction('town', lang('Back to town'));
        }
      }
    }
    $this->render();
  }
 

}

?>
