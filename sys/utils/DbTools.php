<?php
namespace fly\utils;

use \fly\constants as f_constant;

class DbTools
{

    public static function getDbConfig($db_config_key)
    {
        if (empty($db_config_key)) {
            return false;
        }
        
        $config_file = APP_PATH . 'config' . DS . 'databases.php';
        
        if (! file_exists($config_file)) {
            return false;
        }
        
        $config = include $config_file;
        
        if (! empty($config) && isset($config[$db_config_key]) && ! empty($config[$db_config_key])) {
            return $config[$db_config_key];
        }
        
        return false;
    }

    public function makeDsn($config, $factor)
    {
        $mysqlType = $config[f_constant\Constant::DB_CONFIG_SQL_TYPE];
        $host = $config[f_constant\Constant::DB_CONFIG_HOST];
        $port = $config[f_constant\Constant::DB_CONFIG_PORT];
        $db_prefix = $config[f_constant\Constant::DB_CONFIG_DB_PREFIX];
    }
}