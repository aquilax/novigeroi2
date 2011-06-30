<?php

abstract class Base_Map{

  abstract function get_map($x, $y, $spread = 5);

}

class File_Map extends Base_Map{
 
  private $file_name;
  private $width = 0;
  private $height = 0;

  function __construct($map_file_name){
    $this->file_name = $map_file_name;
  }

  function get_map($x, $y, $spread = 5){
    $file = fopen($this->file_name, 'r');
    if (!$file){
      die('Error loading map');
    }
    $lines = array();
    while (!feof($file)){
      $lines[] = fgets($file);
    }
    fclose($file);
    $map = array();
    $default = $lines[0][0];
    for ($ry = $y - $spread; $ry <= $y + $spread; $ry++){
      for ($rx = $x - $spread; $rx <= $x + $spread; $rx++){
        if (isset($lines[$ry][$rx])){
          $map[$ry][$rx] = $lines[$ry][$rx];
        } else {
          $map[$ry][$rx] = $default;
        }
      }
    }
    unset($lines);
    return $map;
  }
}

?>
