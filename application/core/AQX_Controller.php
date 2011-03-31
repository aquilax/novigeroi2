<?php

class AQX_Controller extends CI_Controller{

  protected $status = array('code' => 200, 'message' => 'OK');
  protected $data = array();

  protected $logged = TRUE; // FIXME
  protected $user_id = 1; //FIXME

  function __construct(){
    parent::__construct();
    //$this->output->enable_profiler(TRUE);
  }

  function guard(){
    if (!$this->logged){
      $this->status['code'] = '401';
      $this->status['message'] = 'Unauthorized';
      $this->render();
      die();
    }
  }

  //simple AJAX render
  function render(){
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
