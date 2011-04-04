<?php

class AQX_Controller extends CI_Controller{

  private $status = array('code' => 200, 'message' => 'OK');
  private $data = array();
  private $action = array();

  
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
      if (!in_array($name, $main_methods) && $name[0] != '_'){
        echo $class_name.'/'.$name.'<br />';
      }
    }
  }

  //simple AJAX render
  protected function render(){
    $data = array(
      'status' => $this->status,
      'action' => $this->action,
      'data' => $this->data,
    );
    $this->output->set_status_header($this->status['code'], $this->status['message']);
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode($data));
  }

  function setStatus($code, $message){
    $this->status['code'] = $code;
    $this->status['message'] = $message;
  }

  function setData($data){
    $this->data = $data;
  }

  function addData($key, $val){
    $this->data[$key] = $val;
  }

  function addAction($controller, $message, $format = ''){
    $this->action[] = array(
      'controller' => $controller,
      'message' => $message,
      'format' => $format,
    );
  }

}

?>
