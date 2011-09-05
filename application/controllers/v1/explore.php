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
  }
  
  function move() {
    $dir = $this->uri->segment(4);
    
    $this->load->model('explore_model');
    
    $new_x = $this->hero_model->get('map_x');
    $new_y = $this->hero_model->get('map_y');
    
    switch($dir) {
      case 'n': $new_y--; break;
      case 'e': $new_x++; break;
      case 's': $new_y++; break;
      case 'w': $new_x--; break;       
    }
    if ($this->explore_model->canMove($new_x, $new_y)){
      $this->hero_model->set('map_x', $new_x);
      $this->hero_model->set('map_y', $new_y);
    } else {
      $this->addLog(lang('Thou shall not pass'));
    }
    
    $this->setTitle(lang('Explore'));
    $this->addAction('explore/move/n', lang('North'));
    $this->addAction('explore/move/e', lang('East'));
    $this->addAction('explore/move/s', lang('South'));
    $this->addAction('explore/move/w', lang('West'));    
    
    $actions = $this->explore_model->getActions($new_x, $new_y);
    if ($actions){
      foreach($actions as $row){
        $this->addAction('explore/action/'.$row['id'], $row['message']);
      }
    } else {
      if ($this->explore_model->inFight($new_x, $new_y)){
        $this->redirect('fight');
        return;
      }
    }
    $this->render();
  }
  
  function action(){
    $this->load->model('explore_model');
    $place_id = $this->uri->segment(4);
    $redirect = $this->explore_model->action($place_id);
    $this->redirect($redirect);
  }
  
}

?>
