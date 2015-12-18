<?php
namespace fly\database\factory;

use \fly\utils as f_utils;
use \fly\constants as f_constants;

class Factory
{

    private static $instances = array();

    /**
     * database single instance manager
     *
     * @param \fly\database\DaoInfo $daoInfo            
     * @return \PDO
     */
    public static function getInstance($daoInfo)
    {
        if ($daoInfo->useMasterDsn === true) {
            $dsn = $daoInfo->masterDsn;
        } else {
            $dsn = $daoInfo->slaveDsn;
        }
        
        if (! empty(self::$instances) && isset(self::$instances[$dsn]) && ! empty(self::$instances[$dsn])) {
            return self::$instances[$dsn];
        }
        
        $realStrDsn = f_utils\DbTools::buildDsnByDaoInfo($daoInfo);
        $config = f_utils\DbTools::getConfigByDsn($daoInfo->useMasterDsn ? $daoInfo->masterDsn : $daoInfo->slaveDsn);
        $username = $config[f_constants\Constant::DB_CONFIG_USERNAME];
        $password = $config[f_constants\Constant::DB_CONFIG_PASSWORD];
        $options = isset($config[f_constants\Constant::DB_CONFIG_OPTIONS]) ? $config[f_constants\Constant::DB_CONFIG_OPTIONS] : array();
        $connection = new \PDO($realStrDsn, $username, $password);
        
        self::$instances[$dsn] = $connection;
        
        return self::$instances[$dsn];
    }
}