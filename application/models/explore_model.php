<?php
/**
 * Description of explore_model
 *
 * @author aquilax
 */
class Explore_model extends AQX_Model{
  
  function canMove($x, $y){
    //TODO: check if new coordinates are allowed
    return TRUE;
  }
  
  function getActions($x, $y){
    //POS is Point of significance;
    if ($x == 5 && $y == 5){
      return array(array('id' => 1, 'message' => lang('Enter town')));
    }
    return FALSE;
  }
  
  function inFight($x, $y) {
    $chance = $this->hero_model->get('chance_to_fight', 0);
    $add = ng2_rand(0, 10);
    if ($chance + $add > 100){
      $this->hero_model->set('chance_to_fight', 0);
      $this->hero_model->set('status', 'fight');
      return TRUE;
    } else {
      $this->hero_model->set('chance_to_fight', $chance+$add);
    }
    return FALSE;
  }
  
  function action($place_id){
    //FIXME: Check and set correct place
    $this->hero_model->set('status', 'town');
    $this->hero_model->set('status_ref_id', 1);
    return 'town';
  }
  
}

?>
