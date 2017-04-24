<?php
$act = isset($_GET['a']) ? $_GET['a'] : '';
if(!empty($act)) {
    echo $act;
    die;
}
require_once __DIR__ . '/php/includes/bootstrap.php';
global $container;
$log=$container['monolog'];
var_dump($log);
$log->warning('warning',array('ling'=>__LINE__),array('file'=>__FILE__));
$log->error('error');