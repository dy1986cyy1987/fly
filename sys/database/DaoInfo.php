<?php
namespace fly\database;

class DaoInfo
{

    public $tabName;

    public $dbName;

    public $tabNamePrefix;

    public $dbNamePrefix;

    public $port;

    public $masterDsn;

    public $slaveDsn;

    public $bolSpilt = false;

    public $codeStyle = 'object';

    /**
     *
     * @var object
     */
    public $model;

    /**
     *
     * @var mixed
     */
    public $factor;

    public function changeFactor($factor)
    {
        $this->factor = $factor;
    }

    public function getTableName()
    {
        return $this->tabName;
    }
}