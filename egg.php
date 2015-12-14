<?php

include_once("vendor/autoload.php");

print("\n\nEgg PHP interpreter v 0.0.1\n\n");

if(count($argv) <= 1) {
  die("Useage php egg.php filename.eg\n\n");
}

if(!file_exists($argv[1])) {
  die("Cannot find file {$argv[1]} to process\n\n");
}


$contents = file_get_contents($argv[1]);

// print("{$contents}\n");

$contents = str_replace("\n","",$contents);
$env = new Environment;
$parser = new Parser;
$evaluator = new Evaluator;


$expression = $parser->parseExpression($contents)->getExpression();

// print_r($expression);


$evaluator->evaluate($expression,$env);
