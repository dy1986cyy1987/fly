<?php
namespace fly\database;

use \fly\interfaces as f_interfaces;

abstract class BaseDao implements f_interfaces\DaoInfoInterface
{

    /**
     *
     * @var \fly\database\DaoInfo
     */
    private $daoInfo;

    public function __contruct()
    {
        $this->daoInfo = $this->getDaoInfo();
    }

    public function getDaoInfo()
    {
        return $this->getDaoInfo();
    }

    /**
     *
     * @return \fly\database\DaoInfo
     */
    abstract function getDaoInfoAction();
}