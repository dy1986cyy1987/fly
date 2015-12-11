<?php

/**
 * @Author: dingyong
 * @Date: 2015/12/2 10:20
 */
namespace fly\fly;

class Route
{

    /**
     *
     * @var Route
     */
    private static $instance;

    private function __construct()
    {}

    /**
     *
     * @return Route
     */
    public static function &getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
}