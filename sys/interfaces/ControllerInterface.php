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
    public function beforeHandle();

    /**
     *
     * @return mixed
     */
    public function handle();

    /**
     *
     * @return boolean
     */
    public function checkParams();
}