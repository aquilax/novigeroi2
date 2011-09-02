<?php 

class Place extends AQX_InTown_Controller{
  
  private $hospital_type = 2;

  function __construct(){
    parent::__construct();
    $this->load->model('place_model');
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
    $place_id = (int)$this->uri->segment(4);
    $id = $this->place_model->load(array(
      'town_id' => $this->town_id, 
      'id' => $place_id));
    if(!$id){
      $this->setStatus(404, 'Place not found');       
    } else {
      $this->addMain('description', sprintf(lang('Healing costs %d gold'), $this->place_model->get('price', 10)));
      $this->addMain('price', $this->place_model->get('price', 10));
      $this->addAction('place/hospital_heal/'.$place_id, lang('Heal'));
      $this->addAction('town', lang('Back to town'));
    }
    $this->render();
  }

  function hospital_heal(){
    $place_id = (int)$this->uri->segment(4);
    $id = $this->place_model->load(
      array('town_id' => $this->town_id, 
        'id' => $place_id, 
        'place_type_id' => $this->hospital_type));
    if(!$id){
      $this->setStatus(404, lang('Hospital not found'));
    } else {
      if ($this->hero_model->get('HP') == $this->hero_model->get('HP_max')
        && $this->hero_model->get('MP') == $this->hero_model->get('MP_max')) {
        $this->addLog(lang('No need to heal'));
      } else {
        $price = $this->place_model->get('price', 10); //default to 10 GOLD;
        if ($this->hero_model->get('gold', 0) - $price < 0){
          $this->addData('message', lang('You don\'t have enough money to heal'));  
        } else {
          //All looks fine now;
          $this->hero_model->set('HP', $this->hero_model->get('HP_max'));
          $this->hero_model->set('MP', $this->hero_model->get('MP_max'));
          $this->hero_model->set('gold', $this->hero_model->get('gold')-$price);
          $this->hero_model->save();
          $this->addData('message', lang('Healed'));
        }
      }
    }
    $this->addAction('town', lang('Back to town'));    
    $this->render();
  }
 

}

?>
