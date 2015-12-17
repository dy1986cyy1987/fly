<?php
namespace fly\utils;

use \fly\constants as f_constant;
use \fly\database as f_database;

class DbTools
{

    public static function getDbConfig($db_config_key)
    {
        if (empty($db_config_key)) {
            return false;
        }

        $config_file = APP_PATH . 'config' . DS . 'databases.php';

        if (!file_exists($config_file)) {
            return false;
        }

        $config = include $config_file;

        if (!empty($config) && isset($config[$db_config_key]) && !empty($config[$db_config_key])) {
            return $config[$db_config_key];
        }

        return false;
    }

    /**
     * @param                      $config
     * @param \fly\database\Factor $factor
     *
     * @return string
     */
    public static function getDsn($config, $factor = null)
    {
        $mysqlType = $config[f_constant\Constant::DB_CONFIG_SQL_TYPE];
        $host = $config[f_constant\Constant::DB_CONFIG_HOST];
        $port = isset($config[f_constant\Constant::DB_CONFIG_PORT]) ? $config[f_constant\Constant::DB_CONFIG_PORT] : '';
        $db_prefix = $config[f_constant\Constant::DB_CONFIG_DB_PREFIX];

        $str_port = !empty($port) ? "port={$port};" : '';

        if (empty($factor) || !$factor instanceof f_database\Factor) {
            return "{$mysqlType}:host={$host};{$str_port}dbname={$db_prefix}";
        } else {
            return "{$mysqlType}:host={$host};{$str_port}dbname={$factor->getDbName()}";
        }
    }
}