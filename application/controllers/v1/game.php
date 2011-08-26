<?php

/*
 * JAR Computers internal 
 */

/**
 * Description of game
 *
 * @author aquilax
 */
class Game extends AQX_InGame_Controller{
  
  function index(){
    $this->redirect($this->hero_model->get('status'));
  }
}

?>
