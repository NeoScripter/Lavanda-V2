<?php

$f3 = \Base::instance();
$f3->set('TEST', true);
$f3->set('QUIET', true); 
include_once(__DIR__ . '/../../public/index.php');

echo 'hello world';
