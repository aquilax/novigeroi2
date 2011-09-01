<?php
/*
 * JS Templates generator
 * @author aquilax
 */

if (count($argv) < 2){
  print('Please, set template path.'.PHP_EOL);
  exit(1);
}

$dir = $argv[1];

if (!file_exists($dir)){
  printf('Error: Directory "%s" not found!'.PHP_EOL, $dir);
  exit(2);
}

$dir = rtrim($dir, '/').'/'; //mandatory trailing slash

$files = scandir($dir);

$output = array();

$repl = array(
  '/[\n\r]/' => '',  //remove newlines
  '/>\s+</' => '><', //strip intertag whitespace
);

foreach($files as $file){
  if (!in_array($file, array('.', '..'))){
    $t = preg_replace(array_keys($repl), array_values($repl), file_get_contents($dir.$file));
    $key = basename($file, '.html');
    printf("t['%s'] = '%s';\n", $key, $t);
  }
}

?>
