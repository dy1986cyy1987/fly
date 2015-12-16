<?php
/**
 * @Author: dingyong
 * @Date  : 2015/12/2 16:11
 */

namespace app\controllers;

use \fly\fly as f_fly;

class HomeController extends f_fly\Controller
{

    public function handleInternal()
    {
        \Fly::getInstance()->setAttributes(array(
            'lan' => 'java',
            'type' => 'json',
        ));
        return '\app\views\HomeView';
    }
}