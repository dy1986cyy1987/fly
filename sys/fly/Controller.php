<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:23
 */
namespace fly\fly;

use \fly\interfaces as i_faces;

abstract class Controller implements i_faces\ControllerInterface
{

    public function checkParams()
    {
        return true;
    }

    public function beforeHandle()
    {}

    public function handle()
    {
        return $this->handleInternal();
    }

    public function render($view){

    }

    abstract function handleInternal();
}