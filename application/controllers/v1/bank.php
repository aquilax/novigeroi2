<?php 

class Bank extends AQX_InTown_Controller{
  
  private $place_type_id = 4;

  function __construct(){
    parent::__construct();
    $this->load->model('bank_model');
    $id = $this->bank_model->load(array('town_id' => $this->town_id,
      'place_type_id' => $this->place_type_id));
    if (!$id){
      $this->_guard();  
    }
  }

  function index(){
    $this->addData('name', $this->bank_model->get('name'));
    $this->addData('description', $this->bank_model->get('description'));
    $this->addAction('bank/transactions', lang('Transactions'));
    $this->addAction('bank/deposit', lang('Deposit money'));
    $this->addAction('bank/withdraw', lang('Withdraw money'));
    $this->render();
  }

  function transactions(){
    $this->addData('transactions', $this->bank_model->getTransactions(
      $this->bank_model->get('id'), 
      $this->hero_id,
      TRUE,
      100));
    $this->render();
  }

  function deposit(){
    $sum = (int)$this->uri->segment(4);
    if ($sum > 0){
      $this->hero_model->deposit($sum);  
    }
    $this->render();
  }

  function withdraw(){
    $sum = (int)$this->uri->segment(4);
    if ($sum > 0){
      $this->hero_model->withdraw($sum);  
    }
    $this->render();
  }


}

?>
