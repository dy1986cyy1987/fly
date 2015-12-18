<?php
namespace fly\database;

class BaseModel
{

    protected $cols;

    function __set($name, $value)
    {
        $this->cols[$name] = $value;
    }

    function __get($name)
    {
        return $this->cols[$name];
    }
}