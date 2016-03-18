<?php

error_reporting(E_ALL | E_STRICT);

require_once __DIR__.'/autoload/SplClassLoader.php';

$spl_class_loader=new SplClassLoader('Test',__DIR__.'/vendor/psr0');
$spl_class_loader->register();
$spl_class_loader1=new SplClassLoader('Validator',__DIR__.'/vendor/psr0');
$spl_class_loader1->register();
$spl_class_loader2=new SplClassLoader('Laravel',__DIR__.'/vendor/psr4');
$spl_class_loader2->register();
