<?php
define('DS', DIRECTORY_SEPARATOR);

// app命名空间前缀
define('NAMESPACE_APP_NAME', 'app');

// 系统类命名空间前缀
define('NAMESPACE_SYS_NAME', 'fly');

define('APP_PATH', dirname(__FILE__) . DS);
define('SYS_PATH', APP_PATH . '..' . DS . 'sys' . DS);

// must include the app entrance
include_once (SYS_PATH . 'Fly.php');

$fly = Fly::getInstance();
$fly->setRouter(\fly\fly\Router::getInstance());
$fly->setRequest(\fly\fly\Request::getInstance());
$fly->setResponse(\fly\fly\Response::getInstance());
$fly->run();