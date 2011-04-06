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


class AQX_Logged_Controller extends AQX_Controller{

  protected $logged = FAlSE;
  protected $user_id = -1;

  function __construct(){
    parent::__construct();
    $this->loadCredentials();
    if (!$this->logged){
      $this->guard();
    }
  }

  private function loadCredentials(){
    //FIXME
    $this->logged = TRUE;
    $this->user_id = 1;
  }

  protected function guard(){
    $this->setStatus('401', 'Unauthorized');
    $this->render();
    die('error');//FIXME
  }
}

class AQX_InGame_Controller extends AQX_Logged_Controller{

  protected $hero_id = FALSE;

  function __construct(){
    parent::__construct();
    $this->load->model('hero_model');
    $this->hero_id = $this->getHeroId();
    if (!$this->hero_id){
      $this->guard();  
    }
    $this->hero_model->load(array('id' => $this->hero_id));
  }

  private function getHeroId(){
    //FIXME load real hero;
    return 2; 
  }

  protected function _getRefId(){
    return (int)$this->hero_model->get('status_ref_id', 0);  
  }

}

class AQX_InTown_Controller extends AQX_InGame_Controller{
  
  protected $town_id = FALSE;

  function __construct(){
    parent::__construct();
    $status = $this->hero_model->get('status');
    if ($status != 'town'){
      $this->guard();
    }
    $this->town_id = $this->_getRefId(); 
  }

}

class AQX_Public_Controller extends AQX_Controller{
  
}


?>
