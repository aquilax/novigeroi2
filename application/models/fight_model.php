<?php
/**
 * Description of Fight_Model
 *
 * @author aquilax
 */
class Fight_Model extends AQX_Model{
  
  function fight(){
    echo $this->monster_model->get('id');
    echo $this->hero_model->get('id');
    $this->monster_model->save();
  }
  
}

?>
