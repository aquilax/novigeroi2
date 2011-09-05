<?php

/*
 * JAR Computers internal 
 */

/**
 * Description of map
 *
 * @author aquilax
 */
class Map extends AQX_Logged_Controller{
  
  function get(){
    $tiles = array('G', 'W', 'F', '~');
    $x1 = (int)$this->uri->segment(4);
    $y1 = (int)$this->uri->segment(5);
    $x2 = (int)$this->uri->segment(6);
    $y2 = (int)$this->uri->segment(7);
    if (abs(($x2-$x1) * ($y2-$y1)) > 200) die();
    $b = '';
    for ($y = $y1; $y <= $y2; $y++){
      for ($x = $x1; $x <= $x2; $x++){
        $res = sin(deg2rad($x*10))+sin(deg2rad($y*10));
        if ($res < -1){
          $b .= '~';
        } elseif($res < 0){
          $b .= '.';
        } elseif($res < 1){
          $b .= '*';
        } else {
          $b .= '^';
        }
        //$b .= $tiles[rand(0, count($tiles)-1)];
      }
    }
    $data = array(
      'm' => $b,
      'w' => $x2 -$x1,
      'h' => $y2 -$y1,
    );
    //$this->setMain($data);
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode($data));    
  }
}

?>
