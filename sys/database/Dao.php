<?php
namespace fly\database;

class Dao
{

    /**
     * @var \PDO
     */
    private $connection;

    /**
     *
     * @var \fly\database\Factor
     */
    private $factor;

    /**
     * @param \fly\database\Factor $factor
     */
    public function setFactor($factor){
        $this->factor = $factor;
    }

    public function findByPk($id){

    }

}