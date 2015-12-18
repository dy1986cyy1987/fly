<?php
namespace app\database\dao;

use fly\database as f_database;

class UsersDao extends f_database\BaseDao
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \fly\database\BaseDao::getDaoInfo()
     */
    public function getDaoInfo()
    {
        $daoInfo = new f_database\DaoInfo();
        $daoInfo->tabName = 'users';
        $daoInfo->dbName = 'yicheng';
        $daoInfo->masterDsn = 'home';
        $daoInfo->pkName = 'user_id';
        $daoInfo->useMasterDsn = true;
        $daoInfo->modelClass = '\app\database\model\UsersModel';
        
        return $daoInfo;
    }
}