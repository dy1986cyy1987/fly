<?php
/**
 * Created by PhpStorm.
 * User: yicheng
 * Date: 15/12/16
 * Time: 下午6:58
 */
namespace fly\database;

use \fly\interfaces as f_interfaces;

class Factor implements f_interfaces\DbFactorInterface
{

    protected $sqlType;
    protected $host;
    protected $port;

    /**
     * 确定需要分库
     *
     * @var bool
     */
    protected $needPartDb = true;

    /**
     * 确定需要分表
     *
     * @var bool
     */
    protected $needPartTab = true;

    /**
     * it must be set in function changeFactory($factor) if it is a partial db
     *
     * @var string
     */
    private $dbName;

    /**
     * it must be set in function changeFactory($factor) if it is a partial table
     *
     * @var string
     */
    private $tabName;

    /**
     * 分库分表因子实现
     *
     * @param $factor \fly\database\Factor
     */
    public function changeFactory($factor)
    {

    }

    /**
     * get database name
     *
     * @return string
     */
    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * get table name
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tabName;
    }

    /**
     * get database type
     *
     * @return mixed
     */
    public function getSqlType()
    {
        return $this->sqlType;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }
}