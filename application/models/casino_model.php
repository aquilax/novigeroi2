<?php

class Casino_Model extends AQX_Extended_Model{

  protected $table_name = 'place';

  //FIXME db
  function load(){
    $this->data = array(
      'id' => 4,
      'town_id' => 1,
      'place_type_id' => 1,
      'name' => 'Казино',
      'description' => 'Каза зино',
    );
    return 2;
  }
  
  function bet($bet, $chance){
    $gold1 = $this->hero_model->get('gold1', 0);
    if (($gold1 - $bet) < 0){
      return 0;
    }
    $dice = ng2_rand(0, 100);
    if ($dice < $chance){
      $win = $bet;
      $this->hero_model->set('gold1', $gold1 + $win);
      return $win;
    } else {
      $this->hero_model->set('gold1', $gold1 - $bet);
      return -$bet;
    }
  }  
}

?>
