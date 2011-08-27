<?php
/**
 * Description of Monster_Model
 *
 * @author aquilax
 */
class Monster_Model extends AQX_Extended_Model {
  
  //FIXME db
  function load() {
    $this->data = array(
      'id' => 1,
      'name' => 'Торбалан',
    );
    return 1;
  }
  
  function createMonster() {
    return 1;
  }
  
}

?>
