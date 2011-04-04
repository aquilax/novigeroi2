<?

require_once (APPPATH . 'core/AQX_InGame_Controller.php');

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
