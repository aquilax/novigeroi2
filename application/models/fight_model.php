<?php
/**
 * Description of Fight_Model
 *
 * @author aquilax
 */
class Fight_Model extends AQX_Model{
  
  private $monsterCanHit = TRUE;
  private $messages = array();
  
  public function fight(){
    $cmd = $this->getCommandHero();
    if ($cmd) {
      // Da real deal
      switch ($cmd) {
        case 'spell' : $this->heroSpell(); break;
        case 'hit' : $this->heroHit(); break;
        case 'run' : $this->heroRun(); break;
        default: // Cheating hurts
      }
      $this->monsterHit(); //Monster will try to hit even if you run
    } else {
      $this->messages[] = sprintf(lang('You are fighting %s'), $this->monster_model->get('name'));
      // User's turn no command given show status
    }
    $this->monster_model->save();
    return $this->messages;
  }
  
  private function getCommandHero(){
    return trim($this->uri->segment(4));
  }
  
  private function heroSpell(){
    $this->messages[] = 'you spell';
  }

  private function heroHit(){
    $this->messages[] = 'you hit';
  }
  
  private function heroRun(){
    $this->messages[] = 'you run';
  }
  
  private function monsterHit(){
    $this->messages[] = 'monster hit';
  }

  
}

?>
