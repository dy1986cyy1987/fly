<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:23
 */
namespace fly\fly;

abstract class Controller implements \fly\interfaces\ControllerInterface
{

    public function before()
    {}

    public function handle()
    {
        return $this->handleInternal();
    }

    abstract function handleInternal();

    public function after()
    {}

    public function checkParams()
    {
        return true;
    }
}