<?php
include_once __DIR__ . '/lib/google.php';
include_once __DIR__ . '/lang.php';
ini_set('display_errors', 1);
error_reporting(E_ALL | E_NOTICE);
global $LANG;
$i = 0;
foreach ($LANG as $k => $v){
    echo ++$i. ' => '. $v . PHP_EOL;
}