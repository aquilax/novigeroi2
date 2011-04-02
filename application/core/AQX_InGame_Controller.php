<?php

require_once (APPPATH . 'core/AQX_Logged_Controller.php');

class AQX_InGame_Controller extends AQX_Logged_Controller{

  protected $hero_id = FALSE;

  function __construct(){
    parent::__construct();
    $this->hero_id = $this->getHeroId();
    if (!$this->hero_id){
      $this->guard();  
    }
  }

  private function getHeroId(){
    //FIXME load real hero;
    return 2; 
  }

}


?>
