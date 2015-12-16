<?php

namespace app\views;

use \fly\fly as f_fly;

class HomeView extends f_fly\View {
    public function setPageName(){
        $this->pageName = 'home';
    }
}
