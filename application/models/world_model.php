<?php

class World_model extends AQX_Model{

  function getMap($map_id){
    return $this->_getRow($map_id, 'map');
  }

  function getArea($map_id, $x, $y, $width, $height){
    
  }

  function canMove($map_id, $x, $y, $direction){
     
  }

}

?>
