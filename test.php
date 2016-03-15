<?php
require_once __DIR__.'/bootstrap.php';

use Validator\Check;
use Test\B;
use Test\C;

header('Type:text/txt');
$check=new Check();
$a=new A();
$a->congratulation();
B::b();
C::c();