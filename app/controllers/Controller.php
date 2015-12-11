<?php
namespace app\controllers;

/**
 * @Author: dingyong
 * @Date: 2015/12/2 15:06
 */
class Controller extends \fly\fly\Controller
{

    public static function getClassName()
    {
        return __CLASS__;
    }

    public static function main()
    {
        echo static::getClassName();
    }

    public function handleInternal()
    {}
}