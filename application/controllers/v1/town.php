<?php

class Town extends AQX_InTown_Controller{

  function __construct(){
    parent::__construct();
    $this->load->model('town_model');
  }
  
  function index(){
    $id = $this->town_model->load(array('id' => $this->town_id));
    if (!$id){
      $this->setStatus(404, lang('Town not found'));
    }
    $this->addData('data', array(
      'id' => $this->town_model->get('id'),
      'name' => $this->town_model->get('name'),
      'description' => $this->town_model->get('description', ''),
    ));
    
    $data = $this->town_model->getPlaces($this->town_id); 
    foreach($data as $row){
      $this->addAction($row['controller'].'/'.$row['id'], $row['name']);
    }
    $this->render();    
  }
  
  function info(){
    $id = $this->town_model->load(array('id' => $this->town_id));
    if (!$id){
      $this->setStatus(404, lang('Town not found'));
    }
    $this->addData('data', array(
      'id' => $this->town_model->get('id'),
      'name' => $this->town_model->get('name'),
      'description' => $this->town_model->get('description', ''),
    ));
    
    $this->render();
  }

  function getPlaces(){
    $data = $this->town_model->getPlaces($this->town_id); 
    $this->addData('list', $data);
    foreach($data as $row){
      $this->addAction($row['controller'].'/'.$row['id'], $row['name']);
    }
    $this->render();
  }

}

?>
