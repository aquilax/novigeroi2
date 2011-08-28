<?php
/**
 * Description of Fight_Model
 *
 * @author aquilax
 */
class Fight_Model extends AQX_Model{

  private $monster_can_hit = TRUE;
  private $monster_dead = FALSE;
  private $hero_dead = FALSE;
  private $messages = array();
  public $redirect = FALSE;

  public function fight() {
    $cmd = $this->getCommandHero();
    if ($cmd) {
      // Da real deal
      switch ($cmd) {
        case 'hit' : $this->heroHit(); break;
        case 'spell' : $this->heroSpell(); break;
        case 'run' : if ($this->heroRun()) return $this->messages; break;
        default: // Cheating hurts
      }
      if ($this->hero_dead) {
        $this->redirect = "fight/dead";
        return $this->messages;
      }
      $this->monsterHit(); //Monster will try to hit even if you run
      if ($this->monster_dead) {
        $this->redirect = "fight/vitory";
        return $this->messages;
      }
      $this->monster_model->save();
    } else {
      // User's turn no command given show status
      $this->messages[] = sprintf(lang('You are fighting %s'), $this->monster_model->get('name'));
    }
    return $this->messages;
  }

  private function getCommandHero(){
    return trim($this->uri->segment(4));
  }

  private function hit($attack, $ch_to_at, $defence, $ch_to_bl) {
    $damage = chanced($attack, $ch_to_at) - chanced($defence, $ch_to_bl);
    return nlt($damage, 0); // no healing through hitting
  }

  private function heroHit(){
    $this->messages[] = 'you hit';
    $old_hp = $this->monster_model->get('hp', 0);
    $damage = $this->hit(
            $this->hero_model->get('attack', 0),
            $this->hero_model->get('ch_to_at', 0),
            $this->monster_model->get('defence', 0),
            $this->monster_model->get('ch_to_bl', 0)
          );
    $new_hp = $old_hp - $damage; // decrease health
    if ($damage) {
      $this->messages[] = sprintf(lang('You hit and make %d damage to %s'), $damage,
              $this->monster_model->get('name'));
    } else {
      $this->messages[] = lang('You try to hit, but you miss');
    }
    $new_hp = nlt($new_hp, 0);
    if ($new_hp == 0) {
      $this->monster_dead = TRUE;
      $this->messages[] = 'monster is dead';
    }
    $this->monster_model->set('hp', $new_hp);
  }

  private function monsterHit(){
    if ($this->monster_dead) {
      return;
    }
    $this->messages[] = 'monster hit';
    $old_hp = $this->hero_model->get('hp', 0);
    $damage = $this->hit(
            $this->monster_model->get('attack', 0),
            $this->monster_model->get('ch_to_at', 0),
            $this->hero_model->get('defence', 0),
            $this->hero_model->get('ch_to_bl', 0)
          );
    $new_hp = $old_hp - $damage; // decrease health
    if ($damage) {
      $this->messages[] = sprintf(lang('%s hits and makes %d damage to you'),
              $this->monster_model->get('name'), $damage);
    } else {
      $this->messages[] = sprintf(lang('%s tries to hit, but missses'),
              $this->monster_model->get('name'));
    }
    $new_hp = nlt($new_hp, 0);
    if ($new_hp == 0) {
      $this->hero_dead = TRUE;
      $this->messages[] = 'hero is dead';
    }
    $this->hero_model->set('hp', $new_hp);
  }

  private function heroSpell(){
    $this->messages[] = 'you spell';
  }

  private function heroRun(){
    $this->messages[] = 'you run';
    $can_run = 1; //FIXME should be calculated
    if ($can_run) {
      $this->messages[] = lang('Somehow you manage to escape');
      $this->redirect = "explore";
      return TRUE;
    }
    $this->messages[] = lang('You try to run but do not succeed');
    return FALSE;
  }
}
?>