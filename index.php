<?php
require_once __DIR__ . '/php/bootstrap.php';
include_once __DIR__ . '/php/includes/common.php';
global $container;
$log=$container['monolog'];
$log->warning('warning',array('ling'=>__LINE__),array('file'=>__FILE__));
$log->error('error');

