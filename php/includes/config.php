<?php
define('ROOT_PATH', __DIR__ . '/vagrant_test/');

ini_set('date.timezone','Asia/Shanghai');
ini_set('display_startup_errors','On');
ini_set('display_errors',1);
ini_set('log_errors','On');
header('Content-Type: text/html');
//错误全部报告
error_reporting(E_ALL|E_STRICT);

$config_database=[
	'host'=>'',
	'port'=>'',
	'user'=>'',
	'password'=>''
];

$config_memcached=[
	'host'=>'127.0.0.1',
	'port'=>11211
];

define('MONOLOG_PATH', __DIR__ . '/log/monolog.log');
define('TWIG_TEMPLATE_PATH',__DIR__.'/../html');
