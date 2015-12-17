<?php
namespace fly\database\factory;

use \fly\utils as f_utils;
use \fly\fly as f_fly;

class DbFactory
{

    /**
     * each element is an instance of PDO_Connection
     *
     * @var array
     */
    private static $_connections = array();

    public static function getInstance($db_config_key = '', $factor)
    {
        if (empty($db_config_key)) {
            throw new f_fly\SysException('Db config key must not be empty!');
        }
        
        if (! empty(self::$_connections) && isset(self::$_connections[$db_config_key]) && ! empty(self::$_connections[$db_config_key])) {
            return self::$_connections[$db_config_key];
        }
        
        $config = f_utils\DbTools::getDbConfig($db_config_key);
        
        if ($config === false) {
            throw new f_fly\SysException('Db configure is wrong! key = ' . $db_config_key);
        }
    }
}