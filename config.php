<?php
define('ROOT_PATH', __DIR__ . '/vagrant_test/');

//错误全部报告
error_reporting(E_ALL|E_STRICT);

ini_set('date.timezone','Asia/Shanghai');
ini_set('display_startup_errors','On');
ini_set('display_errors','On');
ini_set('log_errors','On');
header('Content-Type: text/html');
error_reporting(-1);

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
