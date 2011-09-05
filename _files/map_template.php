<?php
$size = 9;
echo '<table id="map">';
for($y = 0; $y < $size; $y++){
  echo '<tr>';
  for($x = 0; $x < $size; $x++){
    printf('<td id="c_%d_%d"></td>', $x, $y);
  }
  echo '</tr>';
}
echo '</table>';
?>
