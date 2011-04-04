<?php

//Increments a value with optional upper limit;
function ng2_inc($current, $val, $max = FALSE){
  $sum = $current + $val;  
  if ($max !==FALSE){
    return ($sum > $max)?$max:$sum;
  }
  return $sum;
}

//Decrements a value with optional lower limit;
function ng2_dec($current, $val, $min = FALSE){
  $sum = $current - $val;  
  if ($min !==FALSE){
    return ($sum < $min)?$min:$sum;
  }
  return $sum;
}

//Returns random number between min and max;
function ng2_rand($min, $max){
  return mt_rand($min, $max);
}

function exp2level($C, $exp){
  return floor($exp^(1/$C));  
}

function level2exp($C, $level){
  return floor($exp^$C);  
}

//Calcultes max value for level
function max_change($new_level, $C1, $C2){
  return floor($new_level*$C1)+$C2;
}


//Dummy translation;
function lang($text){
  return $text;
}

?>
