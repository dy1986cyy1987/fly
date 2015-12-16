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

    public function render($view, $params = array()){
        if (empty($view) || !is_string($view)) {
            return false;
        }

        $view_file = \Fly::getInstance()->getRouter()->getView($view);

        if (file_exists($view_file)) {
            include $view_file;
        }

        return true;
    }

    abstract function handleInternal();
}