<?php
namespace fly\interfaces;

/**
 * @Author: dingyong
 * @Date: 2015/12/2 15:20
 */
interface ControllerInterface
{

    /**
     *
     * @return mixed
     */
    public function before();

    /**
     *
     * @return mixed
     */
    public function handle();

    /**
     *
     * @return mixed
     */
    public function after();
}