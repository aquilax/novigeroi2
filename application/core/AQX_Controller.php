<?php

class AQX_Controller extends CI_Controller{

  private $status = array('code' => 200, 'message' => 'OK');
  private $main = array();
  private $act = array();
  private $sub_act = array();
  private $title = 'Page Title';
  private $hero = array();
  private $log = array();
  protected $prefix = '';
  protected $_data = array();


  function __construct(){
    parent::__construct();
    //$this->output->enable_profiler(TRUE);
  }

  //Poor man's reflection docmentation;
  function index(){
    $main_methods = array_values(get_class_methods(__CLASS__));
    $class_methods = get_class_methods($this);
    $class_name = $this->router->fetch_directory() . $this->router->fetch_class();
    $methods = array();
    foreach ($class_methods as $name){
      if (!in_array($name, $main_methods) && $name[0] != '_'){
        $methods[] = $class_name.'/'.$name;
      }
    }
    $this->addData('methods', $methods);
    $this->render();
  }

  //simple AJAX render
  protected function render(){
    $this->_beforeRender();
    $this->_data = array(
      'status' => $this->status,
      'act' => $this->act,
      'sub_act' => $this->sub_act,
      'title' => $this->title,
      'hero' => $this->hero,
      'log' => $this->log,
      'main' => $this->main,
    );
    $this->fillHero();
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode($this->_data));
  }
  
  function redirect($controller){
    $this->_beforeRender();
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode(array('redirect' => $this->prefix.$controller)));
  }  

  function setTitle($title){
    $this->title = $title;
  }
  
  function setStatus($code, $message){
    $this->status['code'] = $code;
    $this->status['message'] = $message;
  }

  function setHero($data){
    $this->hero = $data;
  }
  
  function setMain($data){
    $this->main = $data;
  }

  function addMain($key, $val){
    $this->main[$key] = $val;
  }

  function addLog($text){
    $this->log[] = $text;
  }  
  
  function addAction($controller, $message, $format = ''){
    $this->act[] = array(
      'controller' => $this->prefix.$controller,
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
    $this->prefix = 'v1/';
    $this->loadCredentials();
    if (!$this->logged){
      $this->_guard();
    }
  }
  
  private function loadCredentials(){
    //FIXME
    $this->logged = TRUE;
    $this->user_id = 1;
  }

  protected function _guard(){
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
      $this->_guard();  
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

  protected function fillHero(){
    $this->_data['hero'] = $this->hero_model->get_array();
  }
  
  protected function _beforeRender(){
    $this->hero_model->save();
  }
}

class AQX_InTown_Controller extends AQX_InGame_Controller{
  
  protected $town_id = FALSE;

  function __construct(){
    parent::__construct();
    $status = $this->hero_model->get('status');
    if ($status != 'town'){
      $this->_guard();
    }
    $this->town_id = $this->_getRefId(); 
  }

}

class AQX_Public_Controller extends AQX_Controller{
  
}


?>
