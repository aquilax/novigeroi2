<?php

class AQX_Logged_Controller extends AQX_Controller{

  protected $logged = FAlSE;
  protected $user_id = -1;

  function __construct(){
    parent::__construct();
    $this->loadCredentials();
    if (!$this->logged){
      $this->guard();
    }
  }

  private function loadCredentials(){
    //FIXME
    $this->logged = TRUE;
    $this->user_id = 1;
  }

  private function guard(){
    $this->setStatus('401', 'Unauthorized');
    $this->render();
    die('error');//FIXME
  }
}

?>
