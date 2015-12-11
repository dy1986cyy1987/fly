<?php
namespace fly\interfaces;

/**
 * @Author: dingyong
 * @Date: 2015/12/2 15:31
 */
interface InterceptorInterface
{

    const STEP_CONTINUE = 1;

    const STEP_BREAK = 2;

    const STEP_EXIT = 3;

    public function before();

    public function ing();

    public function after();
}