<?php

define('DS', DIRECTORY_SEPARATOR);

if (!defined('APP_PATH')) {
    define ('APP_PATH', dirname(__FILE__) . DS);
}

if (!defined('SYS_PATH')) {
    define('SYS_PATH', APP_PATH . '..' . DS . 'sys' . DS);
}

// app auto load configurations
$G_APP_AUTOLOAD_PATH = include(APP_PATH . 'autoload.php');

// must include the app entrance
include_once(SYS_PATH . 'Fly.php');

$fly = Fly::getInstance();
$fly->setRequest(\fly\Request::getInstance());
$fly->setResponse(\fly\Response::getInstance());
$fly->run();