<?php
use \fly\constants as f_constant;

$config = array(
    'home' => array(
        f_constant\Constant::DB_CONFIG_SQL_TYPE => 'mysql',
        f_constant\Constant::DB_CONFIG_HOST => '127.0.0.1',
        f_constant\Constant::DB_CONFIG_PORT => '3306',
        f_constant\Constant::DB_CONFIG_DB_PREFIX => '',
        f_constant\Constant::DB_CONFIG_TAB_PREFIX => '',
        f_constant\Constant::DB_CONFIG_USERNAME => 'root',
        f_constant\Constant::DB_CONFIG_PASSWORD => '',
        f_constant\Constant::DB_CONFIG_TAB_PREFIX => '',
        f_constant\Constant::DB_CONFIG_OPTIONS => array()
    )
);
// \PDO::ATTR_PERSISTENT => false



return $config;