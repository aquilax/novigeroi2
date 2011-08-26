<?php

class Casino extends AQX_InTown_Controller{

  private $place_type_id = 3;
  private $place_id = 0;

  function __construct(){
    parent::__construct();
    $this->load->model('casino_model');
    $this->place_id = (int)$this->uri->segment(4);
    $id = $this->casino_model->load(array('id' => $this->place_id, 
      'town_id' => $this->town_id,
      'place_type_id' => $this->place_type_id));
    if (!$id){
      $this->_guard();
    }
  }
 
  function show(){
    $this->addAction('casino/head_tails/'.$this->place_id, lang('Head or tails'));
    $this->addAction('town', lang('Back to town'));    
    $this->render();
  }
  
  function head_tails(){
    $max_bet = $this->casino_model->get('max_bet', 10);
    $this->addData('name', $this->casino_model->get('title'));
    $this->addData('description', $this->casino_model->get('description'));
    $this->addData('max_bet', $max_bet);
    
    $max_bet = $this->casino_model->get('max_bet', 10);
    $n = (int)($max_bet /5);
    $sec = $max_bet/$n;
    for ($i = 1; $i < $sec; $i++){
      $this->addAction('casino/head_tails_bet/'.$this->place_id.'/'.$n*$i, sprintf(lang('Bet %d gold'), $n*$i));
    }
    $this->addAction('casino/head_tails_bet/'.$this->place_id.'/'.$max_bet, sprintf(lang('Bet %d gold'), $max_bet));
    $this->addAction('casino/show/'.$this->place_id, lang('Back to casino'));
    $this->addAction('town', lang('Back to town'));        
    $this->render();
  }

  function head_tails_bet(){
    $bet = (int)$this->uri->segment(5);
    $max_bet = $this->casino_model->get('max_bet', 10);
    $chance = $this->casino_model->get('chance', 40);
    if ($bet > $max_bet) {
      $this->setStatus(500, 'Bet overflow');
    } elseif ($bet < 1) {
      $this->setStatus(500, 'Bet underflow');
    } else {
      $data = $this->casino_model->bet($bet, $chance);
      if ($data){
        $this->setData($data);
      } else {
        $this->setStatus($this->hero_model->status['code'],
          $this->hero_model->status['message']);
      }
    }
    $this->addAction('casino/head_tails/'.$this->place_id, lang('Bet again'));
    $this->addAction('casino/show/'.$this->place_id, lang('Back to casino'));
    $this->addAction('town', lang('Back to town'));
    $this->render();
  }

}

?>
