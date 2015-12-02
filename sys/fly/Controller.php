<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:23
 */

namespace fly;

abstract class Controller implements ControllerInterface
{
    public function beforeHandle()
    {

    }

    public function handle()
    {
        return $this->handleInternal();
    }

    abstract function handleInternal();

    public function afterHandle()
    {

    }
}