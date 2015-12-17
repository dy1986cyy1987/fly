<?php
namespace fly\database\factory;

use \fly\utils as f_utils;
use \fly\fly as f_fly;
use \fly\database as f_database;

class DbFactory
{

    /**
     * each element is an instance of PDO_Connection
     *
     * @var array
     */
    private static $_connections = array();

    /**
     * @param string               $db_config_key
     * @param \fly\database\Factor $factor
     *
     * @return mixed
     * @throws f_fly\SysException
     */
    public static function getInstance($db_config_key = '', $factor = null)
    {
        if (empty($db_config_key)) {
            throw new f_fly\SysException('Db config key must not be empty!');
        }

        if (!empty(self::$_connections) && isset(self::$_connections[$db_config_key]) && !empty(self::$_connections[$db_config_key])) {
            return self::$_connections[$db_config_key];
        }

        $config = f_utils\DbTools::getDbConfig($db_config_key);

        if ($config === false) {
            throw new f_fly\SysException('Db configure is wrong! key = ' . $db_config_key);
        }

        if (empty($factor) || !$factor instanceof f_database\Factor) {

        } else {

        }

    }
}