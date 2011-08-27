<?php
/**
 * Description of fight
 *
 * @author aquilax
 */
class Fight extends AQX_InGame_Controller {

  function __construct() {
    parent::__construct();
    if ($this->hero_model->get('status') != 'fight') {
      $this->_guard();
    }
    $this->load->model('fight_model');
  }
  
  function index() {
    $monster_id = $this->hero_mode->get('status_ref_id');
    $this->load->model('monster_model');
    if (!$monster_id) {
      $monster_id = $this->fight_model->createMonster();
      $this->hero_model->set('status_ref_id', $monster_id);
    }
    //Prevents monster hijacking
    $this->monster_model->load(array('id' => $monster_id,
        'hero_id' => $this->hero_model->get('id')));
    $this->fight_model->fight();
    $this->render();
  }
  
}

?>
