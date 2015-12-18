<?php
namespace fly\utils;

use fly\fly as f_fly;
use \fly\constants as f_constants;

class DbTools
{

    /**
     *
     * @param string $dsn            
     * @throws f_fly\SysException
     */
    public static function getConfigByDsn($dsn)
    {
        if (empty($dsn)) {
            throw new f_fly\SysException('Dsn Empty Exception!');
        }
        
        $config_path = APP_PATH . 'config' . DS . f_constants\Constant::DB_CONFIG_NAME_IN_APP;
        
        if (! file_exists($config_path)) {
            throw new f_fly\SysException('Does not exits db configure file in APP_PATH!');
        }
        
        $config = include $config_path;
        
        if (empty($config) || ! isset($config[$dsn])) {
            throw new f_fly\SysException('Empty db configure exception!');
        }
        
        return $config[$dsn];
    }

    /**
     *
     * @param \fly\database\DaoInfo $objDaoInfo            
     * @return string
     */
    public static function buildDsnByDaoInfo($objDaoInfo)
    {
        $dsn = $objDaoInfo->useMasterDsn ? $objDaoInfo->masterDsn : $objDaoInfo->slaveDsn;
        $config = self::getConfigByDsn($dsn);
        $host = $config[f_constants\Constant::DB_CONFIG_HOST];
        $dbName = $objDaoInfo->dbName;
        $port = ! empty($objDaoInfo->port) && $objDaoInfo->port != 3306 ? 'port=' . $objDaoInfo->port . ';' : '';
        
        return "mysql:host={$host};{$port}dbname={$dbName}";
    }
}