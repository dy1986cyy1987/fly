<?php
namespace fly\interfaces;

interface Interceptor
{

    /**
     * 前置拦截器，在Controller执行之前执行
     */
    public function before();

    /**
     * 后置拦截器，在Controller动作执行之后
     */
    public function after();
}