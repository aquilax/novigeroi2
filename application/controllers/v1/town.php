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
    $this->setTitle($this->town_model->get('name'));
    $this->addMain('description', $this->town_model->get('description', ''));
    $this->addMain('id', $this->town_model->get('id'));
    
    $data = $this->town_model->getPlaces($this->town_id); 
    foreach($data as $row){
      $this->addAction($row['controller'].'/'.$row['id'], $row['name']);
    }
    $this->addAction('explore', lang('Explore'));
    $this->render();
  }

}

?>
