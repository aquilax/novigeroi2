<?php
/**
 * Description of explore
 *
 * @author aquilax
 */
class Explore extends AQX_InGame_Controller{
  
  function index(){
    //FIXME add explore
    $this->setTitle(lang('Explore'));
    $this->hero_model->set('status', 'explore');
    $this->addAction('explore/move/n', lang('North'));
    $this->addAction('explore/move/e', lang('East'));
    $this->addAction('explore/move/s', lang('South'));
    $this->addAction('explore/move/w', lang('West'));
    $this->render();
  
//    $this->hero_model->set('status_ref_id', '1');
//    $this->redirect('town');
  }
  
  function move() {
    $dir = $this->uri->segment(4);
    switch($dir) {
      case 'n': $this->hero_model->set('map_y', $this->hero_model->get('map_y')-1); break;
      case 'e': $this->hero_model->set('map_x', $this->hero_model->get('map_x')+1); break;
      case 's': $this->hero_model->set('map_y', $this->hero_model->get('map_y')+1); break;
      case 'w': $this->hero_model->set('map_x', $this->hero_model->get('map_x')-1); break;       
    }
    $this->setTitle(lang('Explore'));
    $this->addAction('explore/move/n', lang('North'));
    $this->addAction('explore/move/e', lang('East'));
    $this->addAction('explore/move/s', lang('South'));
    $this->addAction('explore/move/w', lang('West'));
    $this->render();
  }
  
}

?>
