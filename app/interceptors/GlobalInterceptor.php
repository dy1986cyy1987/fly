<?php

namespace app\interceptors;

use \fly\fly as f_fly;

/**
 * App全局拦截器
 *
 * @author dingyong
 *
 */
class GlobalInterceptor extends f_fly\SysInterceptor
{

    public function before()
    {
        return parent::before();
    }

    public function after()
    {
        return parent::after();
    }
}