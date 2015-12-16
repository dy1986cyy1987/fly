<?php

namespace app\views;

use \fly\fly as f_fly;

class HomeView extends f_fly\View
{
    public function setPageName()
    {
        $this->pageName = 'home';
    }

    public function getTitle()
    {
        $title = '这只是我的一个测试实例';

        return $title;
    }

    public function getMeta()
    {
        return array();
    }

    public function getDescription()
    {
        return 'Description';
    }
}
