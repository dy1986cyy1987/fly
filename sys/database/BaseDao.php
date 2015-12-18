<?php
namespace fly\database;

use \fly\database\factory as f_db_factory;
use \fly\constants as f_constants;
use \fly\fly as f_fly;

abstract class BaseDao
{

    /**
     *
     * @var \fly\database\DaoInfo
     */
    private $daoInfo;

    /**
     *
     * @var \PDO
     */
    private $processor;

    public function __construct()
    {
        $this->daoInfo = $this->getDaoInfo();
        $this->processor = f_db_factory\Factory::getInstance($this->daoInfo);
    }

    /**
     *
     * @return \fly\database\DaoInfo
     */
    abstract function getDaoInfo();

    public function getPkName()
    {
        return $this->daoInfo->pkName;
    }

    /**
     * find by primary keys
     *
     * @param int|array $ids            
     * @param array $fieldsParams            
     * @return NULL|object
     */
    public function findByPkIds($ids, $fieldsParams = array())
    {
        if (empty($ids)) {
            return null;
        }
        
        if ($this->daoInfo->pkName == f_constants\Constant::NOT_EXIST_PK_NAME || empty($this->daoInfo->pkName)) {
            return null;
        }
        
        if (is_scalar($ids)) {
            $ids = array(
                $ids
            );
        }
        
        // process string $pkIds
        foreach ($ids as $key => $id) {
            if (is_string($id)) {
                $ids[$key] = "'{$id}'";
            }
        }
        
        $ids = implode(',', $ids);
        
        if (empty($fieldsParams)) {
            $fields = '*';
        } else {
            if (! is_array($fieldsParams)) {
                $fieldsParams = array(
                    $fieldsParams
                );
            }
            
            $fields = implode(',', $fieldsParams);
        }
        
        $statements = "SELECT :fields FROM :tableName WHERE :pkId IN ( :ids )";
        
        try {
            $statements = str_replace(':fields', $fields, $statements);
            $statements = str_replace(':tableName', $this->daoInfo->tabName, $statements);
            $statements = str_replace(':pkId', $this->daoInfo->pkName, $statements);
            $statements = str_replace(':ids', $ids, $statements);
            $stmt = $this->processor->prepare($statements);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->daoInfo->modelClass);
            $stmt->execute();
            $results = $stmt->fetchAll();
            
            return $results;
        } catch (\PDOException $e) {
            if (__DEBUG) {
                echo $e->getMessage();
            }
            exit();
        }
    }

    /**
     * common find
     *
     * @param array $where            
     * @param integer $limit            
     * @param integer $offset            
     * @param array $filedList            
     */
    public function find($where = array(), $limit = f_constants\Constant::DB_FIND_EACH_MAX_NUM, $offset = 0, $filedList = array())
    {
        $statement = "SELECT :fields FROM :tableName WHERE 1 = 1 :stringWhere";
        
        $stringWhere = '';
        $fields = '';
        
        if (! empty($where) && is_array($where)) {
            foreach ($where as $key => $value) {
                if (is_string($value)) {
                    $value = "'{$value}";
                }
                $stringWhere .= ' AND ' . $key . ' = ' . $value;
            }
        }
        
        $stringWhere .= ' LIMIT ' . $limit;
        
        if ($offset > 0) {
            $stringWhere .= ' offset ' . $offset;
        }
        
        if (empty($filedList)) {
            $fields = '*';
        } else {
            $fields = implode(',', $filedList);
        }
        
        $statement = str_replace(':fields', $fields, $statement);
        $statement = str_replace(':tableName', $this->daoInfo->tabName, $statement);
        $statement = str_replace(':stringWhere', $stringWhere, $statement);
        $stmt = $this->processor->prepare($statement);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->daoInfo->modelClass);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * find total number
     *
     * @param array $where            
     * @return int
     */
    public function findCount($where = array())
    {
        $stringWhere = '';
        
        if (! empty($where)) {
            foreach ($where as $key => $value) {
                if (is_string($value)) {
                    $value = "'{$value}";
                }
                $stringWhere .= ' AND ' . $key . ' = ' . $value;
            }
        }
        
        $statement = "SELECT count(1) as total FROM :tableName WHERE 1 = 1 :stringWhere";
        $statement = str_replace(':tableName', $this->daoInfo->tabName, $statement);
        $statement = str_replace(':stringWhere', $stringWhere, $statement);
        $stmt = $this->processor->prepare($statement);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        
        $stmt->execute();
        $result = $stmt->fetch();
        
        return $result['total'];
    }

    /**
     * update colomn
     *
     * @param array $where            
     * @throws f_fly\SysException
     * @return boolean
     */
    public function update($where = array())
    {
        if (empty($where) || ! is_array($where)) {
            throw new f_fly\SysException('Update where condition must be not empty!');
        }
        
        $stringWhere = '';
        
        foreach ($where as $key => $value) {
            // string process
            if (is_string($value)) {
                $value = "'{$value}'";
            }
            
            $stringWhere .= $key . ' = ' . $value . ',';
        }
        
        $statement = "UPDATE :tableName SET :stringWhere";
        
        try {
            $stringWhere = rtrim($stringWhere, ',');
            $statement = str_replace(':tableName', $this->daoInfo->tabName, $statement);
            $statement = str_replace(':stringWhere', $stringWhere, $statement);
            $stmt = $this->processor->prepare($statement);
            $stmt->execute();
            
            return true;
        } catch (\PDOException $e) {
            if (__DEBUG) {
                echo $e->getMessage();
            }
            exit();
        }
    }

    /**
     * single insert
     *
     * @param array $where
     *            array('field1' => 'value1', 'field2' => 'value2' ...)
     * @throws f_fly\SysException
     */
    public function insert($where = array())
    {
        if (empty($where) || ! is_array($where)) {
            throw new f_fly\SysException('Insert where condition must be not empty!');
        }
        
        foreach ($where as $key => $value) {
            // string process
            if (is_string($value)) {
                $where[$key] = "'{$value}'";
            }
        }
        
        $fields = '(' . implode(',', array_keys($where)) . ')';
        $values = '(' . implode(',', array_values($where)) . ')';
        
        try {
            $statement = "INSERT INTO :tableName :fields VALUES :values";
            $statement = str_replace(':tableName', $this->daoInfo->tabName, $statement);
            $statement = str_replace(':fields', $fields, $statement);
            $statement = str_replace(':values', $values, $statement);
            $stmt = $this->processor->prepare($statement);
            $stmt->execute();
            
            return $this->processor->lastInsertId();
        } catch (\PDOException $e) {
            if (__DEBUG) {
                echo $e->getMessage();
            }
            exit();
        }
    }

    /**
     * multi insert
     *
     * @param array $where
     *            array(
     *            array('field1' => 'value1', 'field2' => 'value2' ...),
     *            array('field1' => 'value1', 'field2' => 'value2' ...),
     *            ...
     *            array('field1' => 'value1', 'field2' => 'value2' ...),
     *            )
     * @throws f_fly\SysException
     * @return string
     */
    public function insertMulti($where = array())
    {
        if (empty($where) || ! is_array($where)) {
            throw new f_fly\SysException('Insert multi where condition must be not empty!');
        }
        
        $stringWhere = '';
        
        $arr_fields = array();
        
        foreach ($where as $subWhere) {
            if (empty($subWhere) || ! is_array($subWhere)) {
                continue;
            }
            
            $subStringWhere = '(';
            
            foreach ($subWhere as $key => $value) {
                $arr_fields[$key] = $key;
                if (is_string($value)) {
                    $value = "'{$value}'";
                }
                $subStringWhere .= $key . ' = ' . $value . ',';
            }
            
            $subStringWhere = rtrim($subStringWhere, ',');
            $subStringWhere .= '),';
            $stringWhere .= $subStringWhere;
        }
        
        $stringWhere = trim($stringWhere, ',');
        $fields = '(' . implode(',', $arr_fields) . ')';
        
        try {
            $statement = "INSERT INTO :tableName :fields VALUES :stringWhere";
            $statement = str_replace(':tableName', $this->daoInfo->tabName, $statement);
            $statement = str_replace(':fields', $fields, $statement);
            $statement = str_replace(':stringWhere', $stringWhere, $statement);
            $stmt = $this->processor->prepare($statement);
            $stmt->execute();
            
            return $this->processor->lastInsertId();
        } catch (\PDOException $e) {
            if (__DEBUG) {
                echo $e->getMessage();
            }
            exit();
        }
    }

    /**
     * trunck the whole table
     */
    public function trunck()
    {
        $statemet = "TRUNCATE :tableName";
        
        try {
            $statemet = str_replace(':tableName', $this->daoInfo->tabName, $statemet);
            $stmt = $this->processor->prepare($statemet);
            $stmt->execute();
        } catch (\PDOException $e) {
            if (__DEBUG) {
                echo $e->getMessage();
            }
            exit();
        }
    }

    /**
     * delete from table
     *
     * @param array $where            
     * @throws f_fly\SysException
     * @return boolean
     */
    public function delete($where = array())
    {
        if (empty($where) || ! is_array($where)) {
            throw new f_fly\SysException('Delete where condition must be not empty!');
        }
        
        $statement = "DELETE FROM :tableName WHERE 1 = 1 :stringWhere";
        $stringWhere = '';
        
        foreach ($where as $key => $value) {
            if (is_string($value)) {
                $value = "'{$value}'";
            }
            
            $stringWhere .= ' AND ' . $key . ' = ' . $value;
        }
        
        try {
            
            $statement = str_replace(':tableName', $this->daoInfo->tabName, $statement);
            $statement = str_replace(':stringWhere', $stringWhere, $statement);
            $stmt = $this->processor->prepare($statement);
            $stmt->execute();
            
            return true;
        } catch (\PDOException $e) {
            if (__DEBUG) {
                echo $e->getMessage();
            }
            exit();
        }
        
        return true;
    }
}