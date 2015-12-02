<?php

namespace app\controller;
use fly;

/**
 * @Author: dingyong
 * @Date: 2015/12/2 15:06
 */
class LanguageController extends fly\Controller{

    public static function getClassName(){
        return __CLASS__;
    }

    public static function main() {
        echo static::getClassName();
    }
}