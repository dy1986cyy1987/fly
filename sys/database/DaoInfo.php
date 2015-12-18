<?php
namespace fly\database;

use \fly\constants as f_constants;

class DaoInfo
{

    public $tabName;

    public $dbName;

    public $tabNamePrefix;

    public $dbNamePrefix;

    public $port;

    public $masterDsn;

    public $slaveDsn;

    public $pkName = f_constants\Constant::NOT_EXIST_PK_NAME;

    /**
     * \fly\database\BaseModel
     *
     * @var string
     */
    public $modelClass;

    public $bolSpilt = false;

    public $codeStyle = \PDO::FETCH_OBJ;

    public $useMasterDsn = true;

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