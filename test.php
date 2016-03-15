<?php
require_once __DIR__.'/bootstrap.php';

use Validator\Check;
use Test\B;
use Test\C;
$check=new Check();
$a=new A();
$a->congratulation();
echo PATH_SEPARATOR.PHP_EOL;
echo get_include_path();
B::b();
C::c();