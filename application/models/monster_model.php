<?php
/**
 * Description of Monster_Model
 *
 * @author aquilax
 */
class Monster_Model extends AQX_Extended_Model {
  
  protected $table_name = 'monster'; //monsters table;
  
  //FIXME db
  function load() {
    $this->data = $this->session->userdata($this->table_name);
    if (!$this->data) {
      $this->data = array(
        'id' => 1,
        'name' => 'Торбалан',
        'hp' => 30,
        'defence' => ng2_rand(1, 5),
        'attack' => ng2_rand(1, 5)
      );
    }
    return 1;
  }
  
  //FIXME db
  function save(){
    $this->session->set_userdata($this->table_name, $this->data);
  }
    
  function killMonster($id){
    $this->session->unset_userdata($this->table_name);
  }
  
  function createMonster() {
    return 1;
  }
  
}

?>
