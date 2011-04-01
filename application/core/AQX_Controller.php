<?php

class AQX_Controller extends CI_Controller{

  protected $status = array('code' => 200, 'message' => 'OK');
  protected $data = array();

  protected $logged = TRUE; // FIXME
  protected $user_id = 1; //FIXME
  protected $hero_id = 2; //FIXME

  function __construct(){
    parent::__construct();
    //$this->output->enable_profiler(TRUE);
  }


  //Poor man's reflection docmentation;
  function index(){
    $main_methods = array_values(get_class_methods(__CLASS__));
    $class_methods = get_class_methods($this);
    $class_name = $this->router->fetch_directory() . $this->router->fetch_class();
    foreach ($class_methods as $name){
      if (!in_array($name, $main_methods)){
        echo $class_name.'/'.$name.'<br />';
      }
    }
  }

  protected function guard(){
    if (!$this->logged){
      $this->status['code'] = '401';
      $this->status['message'] = 'Unauthorized';
      $this->render();
      die();
    }
  }

  //simple AJAX render
  protected function render(){
    $data = array(
      'status' => $this->status,
      'data' => $this->data,
    );
    $this->output->set_status_header($this->status['code'], $this->status['message']);
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode($data));
  }

}

?>
