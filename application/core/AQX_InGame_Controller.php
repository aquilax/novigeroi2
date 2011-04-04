<?php

require_once (APPPATH . 'core/AQX_Logged_Controller.php');

class AQX_InGame_Controller extends AQX_Logged_Controller{

  protected $hero_id = FALSE;

  function __construct(){
    parent::__construct();
    $this->load->model('hero_model');
    $this->hero_id = $this->getHeroId();
    if (!$this->hero_id){
      $this->guard();  
    }
    $this->hero_model->load($this->hero_id);
  }

  private function getHeroId(){
    //FIXME load real hero;
    return 2; 
  }

  protected function _getRefId(){
    return $this->hero_model->get('status_ref_id', 0);  
  }

}


?>
