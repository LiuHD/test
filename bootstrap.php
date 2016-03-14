<?php

error_reporting(E_ALL | E_STRICT);

require_once __DIR__.'/autoload/SplClassLoader.php';

$spl_class_loader=new SplClassLoader(null,__DIR__.'/vendor/psr0');
$spl_class_loader->register();
