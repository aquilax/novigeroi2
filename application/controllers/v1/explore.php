<?php
/**
 * Description of explore
 *
 * @author aquilax
 */
class Explore extends AQX_InGame_Controller{
  
  function index(){
    //FIXME add explore
    $this->hero_model->set('status', 'town');
    $this->hero_model->set('status_ref_id', '1');
    $this->redirect('town');
  }
  
}

?>
