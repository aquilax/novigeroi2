<?php
/**
 * Description of fight
 *
 * @author aquilax
 */
class Fight extends AQX_InGame_Controller {

  function __construct() {
    parent::__construct();
    if (substr($this->hero_model->get('status'), 0, 5) != 'fight') {
      $this->_guard();
    }
    $this->load->model('fight_model');
  }
  
  function index() {
    $monster_id = $this->hero_model->get('status_ref_id');
    $this->load->model('monster_model');
    if (!$monster_id) {
      $monster_id = $this->fight_model->createMonster();
      $this->hero_model->set('status_ref_id', $monster_id);
    }
    //Prevents monster hijacking
    $this->monster_model->load(array('id' => $monster_id,
        'hero_id' => $this->hero_model->get('id')));
    $messages = $this->fight_model->fight();
    
    if ($this->fight_model->redirect) {
      $this->hero_model->set('status', $this->fight_model->redirect);
      $this->redirect($this->fight_model->redirect);
      return;
    }

    $this->setTitle(lang('Fight'));
    foreach ($messages as $m){
      $this->addLog($m);
    }
    //Monster
    $this->addMain('m_name', $this->monster_model->get('name'));
    $this->addMain('m_hp', $this->monster_model->get('hp', 0));
    $this->addMain('m_mp', $this->monster_model->get('mp', 0));
    $this->addMain('m_attack', $this->monster_model->get('attack', 0));
    $this->addMain('m_defence', $this->monster_model->get('defence', 0));
    //Hero
    $this->addMain('h_name', $this->hero_model->get('name'));
    $this->addMain('h_hp', $this->hero_model->get('hp', 0));
    $this->addMain('h_mp', $this->hero_model->get('mp', 0));
    $this->addMain('h_attack', $this->hero_model->get('attack', 0));
    $this->addMain('h_defence', $this->hero_model->get('defence', 0));
    
    //$this->addData('monster', $this->monster_model->get_array());
    $this->addAction('fight/index/hit', lang('Hit'));
    $this->addAction('fight/index/spell', lang('Spell'));
    $this->addAction('fight/index/run', lang('Run'));
    $this->render();
  }

  /*
   * You are dead
   */
  
  function dead() {
    $this->setTitle(lang('Beaten'));
    $this->addMain('description', lang('Unfortunately you are badly injured'));
    $this->hero_model->killHero();
    $this->hero_model->set('status', 'town');
    $this->addAction('town', lang('Back to town'));
    $this->render();
  }
  
  /*
   * Monster is dead
   */  
  function victory() {
    $this->setTitle(lang('Victory'));
    $this->addMain('description', lang('Such a glorious victory'));
    $this->addAction('explore', lang('Explore'));
    $this->load->model('monster_model');
    $monster_id = $this->hero_model->get('status_ref_id');
    $this->monster_model->killMonster($monster_id);
    $this->hero_model->set('status', 'explore');
    $this->render();
  }
}

?>
