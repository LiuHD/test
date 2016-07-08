<?php

require_once __DIR__ . '/config.php';
require_once __DIR__.'/../../vendor/autoload.php';

use Pimple\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$container=new Container();

$container['memcache']=function($c) {
    global $config_memcached;
    $memcache = new \Memcached(); //创建一个memcache对象
    $memcache->addServer($config_memcached['host'],$config_memcached['port']);
    //设置session驱动为memcached
    ini_set('session.save_handler', 'memcached');
    ini_set('session.save_path', 'tcp://localhost:11211');
    return $memcache;
};
//create a log channel
$container['monolog']=function($c) {
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler(MONOLOG_PATH, Logger::WARNING));
    return $log;
};

$container['twig']=function($c) {
    $loader = new Twig_Loader_Filesystem(TWIG_TEMPLATE_PATH);
    $twig = new Twig_Environment($loader);
    return $twig;
};
